<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}

$random_string_len = 15;
$line_break = false;

require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || $AUTHUSER['roles'] == 0)
{
    die("Bad request");
}

$running_func = CSRF::GenStringWithoutNumber(rand(5,10));
$aze_func = CSRF::GenStringWithoutNumber(rand(5,10));
$getinfo_func = CSRF::GenStringWithoutNumber(rand(5,10));

$key = 96;
$o = 1;

$code = str_replace("<NEWLINE>", "\n", $_POST['code']);
$code .= " -- ";
$endtbl = "local AE = {";

foreach (str_split($code) as $char) {
	$e = ord($char);
	$endtbl .= ($e ^ $key) . ",";
}

$endtbl .= "0}";

Logs::AddLogs(
	"User ".htmlentities($AUTHUSER['username'])." used the obfuscator tools for this code (".htmlentities($_POST['code']).")", 
	"purple", 
	"fa fa-code"
);


?>RunString([[ <?php echo $endtbl; ?> local function RunningDRMe()if (debug.getinfo(function()end).short_src~="tenjznj")then return end for o=500,10000 do local t=0 if t==1 then return end  if o~=string.len(string.dump(RunningDRMe))then  AZE=10  CompileString("for i=1,40 do AZE = AZE + 1 end","RunString")()  if AZE<40 then return end continue  else  local pdata=""  xpcall(function()  for i=1,#AE do  pdata=pdata..string.char(bit.bxor(AE[i],o%150))  end  for i=1,string.len(string.dump(CompileString)) do  while o==1 do  o=o+<?php echo $o; ?>  end  end  end,function()  xpcall(function()  local debug_inject=CompileString(pdata,"DRME")  pcall(debug_inject,"stat")  pdata="F"  t=1  end,function()  print("error")  end)  end)  end  end end RunningDRMe() ]],"tenjznj")