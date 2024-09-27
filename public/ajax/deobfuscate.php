<?php
session_start();
if(!isset($_SESSION['user']['id'])) {
	die();
}
require_once('../../app/Models/includes.php');
if (!User::isAuthentified() || !CSRF::isAjaxRequest() || $AUTHUSER['roles'] == 0)
{
    die("Bad request");
}

// DECODEUR
if(isset($_POST["code"])){

	$obfukey = 108;

	$code = $_POST["code"];

	if(preg_match("#{#", $_POST["code"])){
		$code = explode('{', $code);
		$code = $code[1];
	}
	if(preg_match("#}#", $_POST["code"])){
		$code = explode('}', $code);
		$code = $code[0];
	}

	if(preg_match("#RunningDuck#", $_POST["code"])){
		$obfukey = 97;
	}

	if(preg_match("#Drmdontouch()#", $_POST["code"])){
		$obfukey = 97;
	}

	if(preg_match("#RunningDRMe()#", $_POST["code"])){
		$obfukey = 96;
	}

	$encodetbl = $code;

	$str_cut = explode(',', $encodetbl);

	foreach ($str_cut as $deobfusque) {
		$x= $deobfusque;
		$y=$obfukey;
		echo chr($x ^ $y);
	}

	Logs::AddLogs(
		"User ".htmlentities($AUTHUSER['username'])." used the deobfuscator tools for this code (".htmlentities($encodetbl).")", 
		"purple", 
		"fa fa-code"
	);

}

?>