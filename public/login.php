<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER['HTTP_USER_AGENT'] == "Valve/Steam HTTP Client 1.0 (4000)"){
    die("Ton navigateur n'est pas autoriser a se connecter sur KVacDoor | https://discord.gg/MrJUbQ72kj");
}

$discordUrl = "https://discordapp.com/api/oauth2/authorize?client_id=1178285661233631243&redirect_uri=http%3A%2F%2F178.33.179.185%2Flogin.php&response_type=code&scope=identify%20email%20guilds&prompt=none";

if($_SERVER['REQUEST_METHOD'] !== "GET"){
    die(header('Location:'. $discordUrl));
}

session_start();

if (isset($_GET['returnUrl'])) {
    $_SESSION['login']['return'] = $_GET['returnUrl'];
}

require_once '../app/Models/CSRF.php';

if(CSRF::isAjaxRequest()){
    die(http_response_code(444));
}

if (isset($_SESSION['user']['id'])) {
    die(header('Location:/overview'));
}

if(isset($_GET['code'])){
    if ($_SESSION['juiferiejamaisfinit'] != 1) {
        die(header('Location:/'));
    }
}
unset($_SESSION["juiferiejamaisfinit"]);


if(!isset($_GET['code'])) {
    $csrf = CSRF::GenString(64);
    $time = time();

    file_put_contents("assets/login.txt", $csrf . "@" . $time . "\n", FILE_APPEND);

    $_SESSION['login']['csrf'] = $csrf;
    $_SESSION['login']['time'] = $time;

    $_SESSION['juiferiejamaisfinit'] = 1;
    die(header('location:'. $discordUrl));
}


$getcsrf = "yofrere";
$valid_csrf = false;
$csrf_check = file_get_contents("assets/login.txt");
$cut = explode("\n", $csrf_check);
$zizi = [];

if(strlen($csrf_check) > 1000495) {
    file_put_contents("assets/login.txt", "");
}


foreach($cut as $line) {
    if(isset($_SESSION['login']['csrf'])){
        $getcsrf = $_SESSION['login']['csrf'];
    }
    if(strpos($line, $getcsrf) !== false){
        $valid_csrf = true;
    }
}


if(!$valid_csrf){
    die(http_response_code(404));
    // die("Une erreur s'est produite");
}






// INIT VARIABLE
$redirect_uri = "http://178.33.179.185/login.php";
$token_request = "https://discordapp.com/api/oauth2/token";


// CREATE CONNEXION WITH DISCORD
$token = curl_init();
curl_setopt_array($token, array(

    CURLOPT_URL => $token_request,
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => array(

        "grant_type" => "authorization_code",
        "client_id" => "1178285661233631243",
        "client_secret" => "eX1HQEj8nrVW1b9VSwy59rcxX1TC5vcH",
        "redirect_uri" => $redirect_uri,
        "code" => $_GET["code"]

    )
));

curl_setopt($token, CURLOPT_RETURNTRANSFER, true);
$resp = json_decode(curl_exec($token));
curl_close($token);

// SI UNE REPONSE EXISTE
if (isset($resp->access_token)) {

	// PREPARATION A RECUPERER LES INFOS
    $access_token = $resp->access_token;
    $info_request = "https://discordapp.com/api/users/@me";

    $info = curl_init();
    curl_setopt_array($info, array(

        CURLOPT_URL => $info_request,

        CURLOPT_HTTPHEADER => array(

            "Authorization: Bearer {$access_token}"

        ),

    	CURLOPT_RETURNTRANSFER => true

    ));

    // DECODAGE DES INFO
    $user = json_decode(curl_exec($info));
    curl_close($info);

    $info_request = "https://discordapp.com/api/users/@me/guilds";
    $info = curl_init();
    curl_setopt_array($info, array(
        CURLOPT_URL => $info_request,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer {$access_token}"
        ),
        CURLOPT_RETURNTRANSFER => true
    ));
    $guilds = json_decode(curl_exec($info));
    curl_close($info);

    //var_dump($guilds);

    $onKvacDiscord = false;
    $onKvacDiscord2 = true;
    // BYPASS ALEX WADIXIX DELPHINE

    $whitelist = [
        566035268373577738, // WaDixix
        531547952880156673, // Alex
        1208027323123638306, // Plataodos
        // 403607883637456906, // FrenchHardware
        317297046182690817, // DC WaDixix
        676143769128534034, // Leon
        // 1037427567457747014 // zUnlegit
    ];

    if(!in_array((int)$user->id, $whitelist))
    {
	    foreach ($guilds as $guild) {

	    	// DISCORD KVACDOOR
	        if($guild->id == 566035622972620800){
	            $onKvacDiscord = true;
	        }

            // DISCORD KVACDOOR CONTREFACON
	        if($guild->id == 1076324489903755335){
	            // $onKvacDiscord2 = true;
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
	        }

            // // Brigade, full BD workshop
            // if($guild->id == 816702678247145522){
            //     die(header('location:advert?msg=bad_discord&name='. $guild->name));
            // }

            // Sheitaned
            if($guild->id == 558701935532834836){
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
            }

            // Silence Network
            if($guild->id == 1073014767410749540){
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
            }

            // Omega
            if($guild->id == 821495827108331561){
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
            }

            // GayShop (Seefox ft Greg)
            if($guild->id == 1064835537338388540){
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
            }

            // // SmartBot
            if($guild->id == 870044292813570188){
                die(header('location:advert?msg=bad_discord&name='. $guild->name));
            }

	    }
	} else {
		$onKvacDiscord = true;
        $onKvacDiscord2 = true;
    }
    
    // session_destroy();
    require_once '../app/Models/includes.php';

    if($onKvacDiscord){

        if (!$onKvacDiscord2) {
            die("Tu n'est pas présent sur le Discord Backup de KVacDoor! https://discord.gg/mgdcG8hPnQ<br>Connecter en tant que : {$user->username}");
        }

        if(User::UserExistByDiscordID($user->id))
        {
            $avatar = "https://cdn.discordapp.com/avatars/{$user->id}/{$user->avatar}";
            $username = $user->username;
            $email = $user->email;

            $base64 = base64_encode(file_get_contents($avatar));
            file_put_contents("assets/img/profile/{$user->id}.png", base64_decode($base64));

            $data_user = $GLOBALS['DB']->GetContent('users', ['discord_id' => $user->id])[0];
            if($data_user['active'] == 1 && $data_user['ban'] == 0){
                Profile::EditLogin($data_user['id'], $email, $username, $user->discriminator, $avatar, $user->premium_type ?? 0, $access_token);

                $_SESSION['user']['id'] = $data_user['id'];
                $_SESSION['user']['ip'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                $GLOBALS['DB']->Update("users", ['id' => $data_user['id']], ['ip' => $_SERVER["HTTP_CF_CONNECTING_IP"]]);

                Logs::AddLogs(
                    "User ". htmlentities($data_user['username'])." logged in.",
                    "secondary",
                    "fa fa-sign-in-alt"
                );

                $_SESSION['ads'] = 1;

                if ($_SESSION['login']['return'] !== null) {
                    die(header('location:'.$_SESSION['login']['return']));
                }
                die(header('location:/overview'));
            } elseif($data_user['active'] == 0 && $data_user['ban'] == 0) {
                die(header('location:advert?msg=waiting_approbate'));
            } elseif($data_user['ban'] == 1){

                Logs::AddLogs(
                    "Banned user ".$data_user['username']." attempted to log in.",
                    "secondary",
                    "fa fa-ban"
                );

                die('Ton compte est désactiver!');
            }
        } else {
            die(header('location:advert?msg=account_not_exist'));
        }
    } else {

        Logs::AddLogs(
            "User ". $user->username." logged in but is not verified on Discord.", 
            "danger", 
            "fab fa-discord"
        );

        die("Tu n'est pas présent sur le nouveau discord KvacDoor! https://discord.gg/mgdcG8hPnQ<br>Connecter en tant que : {$user->username}");
    }

} else {
    die(header('location:'. $discordUrl));
}