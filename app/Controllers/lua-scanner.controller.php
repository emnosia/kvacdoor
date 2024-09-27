<?php

ini_set('memory_limit', '1000M');

if($AUTHUSER['roles'] == 0) {
	Logs::AddLogs(
		"User ".$AUTHUSER['username']." attempted to access a premium page (Lua Scanner)", 
		"danger", 
		"fas fa-baby-carriage"
	);
	die(header('location:/overview'));
}

$backdoorList = array(
	'RunString' => ['name' => 'RunString Function', 'level' => '1'],
	'RunStringEx' => ['name' => 'RunStringEx Function', 'level' => '1'],
	'CompileString' => ['name' => 'CompileString Function', 'level' => '1'],
	'http.Fetch' => ['name' => 'http.Fetch Function', 'level' => '0'],
	'http.Post' => ['name' => 'http.Post Function', 'level' => '0'],
	'HTTP' => ['name' => 'HTTP Function', 'level' => '0'],
	'RunHASHOb' => ['name' => 'John Ducksent Obfuscator', 'level' => '3'],
	'kvac.' => ['name' => 'KVacDoor Panel', 'level' => '3'],
	'kvacdoor.' => ['name' => 'KVacDoor Panel', 'level' => '3'],
	'gblk' => ['name' => 'GHackDoor Panel', 'level' => '3'],
	'local hash1 = sep' => ['name' => 'Cipher-Panel Obfuscated', 'level' => '3'],
	'local OMEGA' => ['name' => 'Omega Panel Obfuscated', 'level' => '3'],
	'function(__,anti_lag)' => ['name' => 'Omega Panel Obfuscated', 'level' => '3'],
	'local chat_admin' => ['name' => 'Omega Panel Obfuscated', 'level' => '3'],
	'omega-project.cz' => ['name' => 'Omega Panel', 'level' => '3'],
	'local file = "api_connect.php"' => ['name' => 'Omega Panel Obfuscated', 'level' => '3'],
	'gvac' => ['name' => 'GVacDoor Panel | Enigma', 'level' => '3'],
	'cipher-panel' => ['name' => 'Cipher-Panel', 'level' => '3'],
	'RunningDuck' => ['name' => 'GHackDoor Obfusator', 'level' => '3'],
	'local function _(_) end _=_G _____=_["\76\101\114\112\86\101\99\116\111\114"] ______=_["\83\84\78\68\82\68"]' => ['name' => 'Gizeh-Panel Obfuscator', 'level' => '3'],
	'7,26,13,15' => ['name' => 'KVacDoor Panel Obfuscated', 'level' => '3'],
	'24,5,1,9,30,66,63,5,1,28,0,9,68,93,64,76,10,25,2,15,24,5,3,2,68,69,76,4,24,24,28,66,42,9,24,15,4,68,78,4,24,24,28,31,86,67,67,11,26,13,15,66,15,22' => ['name' => 'GVacDoor Panel Obfuscated', 'level' => '3'],
	'11,22,1,3' => ['name' => 'KVacDoor Panel Obfuscated', 'level' => '3']
);

if(!empty($_FILES["file"]["name"])) {
	$fileName = $_FILES["file"]["name"];
	$fileSource = $_FILES["file"]["tmp_name"];
	$fileType = pathinfo($fileName, PATHINFO_EXTENSION);

	if (!is_uploaded_file($fileSource)) {
		$errors[] = 'error';
	}

	if ($fileType != 'zip') {
		$errors[] = 'Le fichier n\'est pas une archive ZIP valide.';
	}
	
	$root_repertory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR;
	
	// DEPLACER LE FICHIER DANS LE DOSSIER UPLOAD
	$targetPath = $root_repertory."data/luascanner/".$fileName;
	if(!isset($errors)) {

		if(move_uploaded_file($fileSource, $targetPath)) {
			$zipArchive = new ZipArchive();

			$zipArchive->open($targetPath);
		  
			for ($i = 0; $i < $zipArchive->numFiles; $i++) {

				// Bypass generated filesteal info file
				if ($zipArchive->getNameIndex($i) === "filestealed with kvacdoor.txt") continue;

				foreach ($backdoorList as $backdoorPattern => $backdoorDescription) {
					if (preg_match("#".$backdoorPattern."#", $zipArchive->getFromIndex($i))) {
						$detectedBackdoors[$zipArchive->getNameIndex($i)][] = $backdoorDescription;
					}
				}
			}
		  
			$zipArchive->close();

            Logs::AddLogs(
	            "User ".htmlentities($AUTHUSER['username'])." scanned file: " . $fileName . " with the Lua Scanner", 
	            "info", 
	            "fa fa-file-code"
            );

		} else {
			$errors[] = "Une erreur s'est produite !"; // MOVE FILE
		}

	} // !ISSET $errors

}
