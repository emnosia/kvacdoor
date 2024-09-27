<?php
class Player {
    /**
     * The name of the database table containing player information.
     *
     * @var string
     */
    const TABLE = 'players';

    /**
     * Checks whether a given player with a specific Steam ID exists in the database
     *
     * @param string $steamid The Steam ID of the player to check
     * @return bool Whether the player exists in the database
     */
    public static function PlayerExist($steamId)
    {
        return $GLOBALS['DB']->Count(self::TABLE, ["steamid64" => $steamId]) != 0;
    }

	// Récupére le joueur
	public static function GetPlayer($id)
	{
		return $GLOBALS['DB']->GetContent(self::TABLE, ["id" => $id])[0];
    }
    
    // Récupére le nombre total de Serveurs
    public static function count()
    {
        return 325994 * 2;
        //return $GLOBALS['DB']->Count(self::TABLE);
    }

    // insert le serveur
    static function InsertPlayer($steamname, $steamid, $ip, $country, $server, $time)
    {
        $GLOBALS['DB']->Insert(
            self::TABLE, 
            [
                'username' => $steamname,
                'steamid64' => $steamid,
                'ip' => $ip,
                'country' => $country,
                'last_server' => $server,
                'updated_at' => $time
            ]
        );
    }

    // Update le joueur
    static function UpdatePlayer($steamid, $steamname, $ip, $country, $server, $time)
    {
        $GLOBALS['DB']->Update(
            self::TABLE, 
            [
                'steamid64' => $steamid
            ], 
            [
                'username' => $steamname,
                'ip' => $ip,
                'country' => $country,
                'last_server' => $server,
                'updated_at' => $time
            ]
        );
    }

    // Update blacklist
    static function UpdateBlacklist($steamid, $blacklist)
    {
        $GLOBALS['DB']->Update(
            self::TABLE, 
            [
                'steamid64' => $steamid
            ], 
            [
                'blacklist' => $blacklist,
            ]
        );
    }

    public static function getSteamProfile($steam_id)
    {
        // global $memcache;

        // $user = $memcache->get("player-{$steam_id}");

        // if ($user) {
        //     return unserialize($user);
        // } else {
            $api = file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=6192A155B22B585694C24CC24029FA76&steamids={$steam_id}");
            $api = json_decode($api);

            $value = $api->response->players[0];
            // $memcache->set("player-{$steam_id}", serialize($value), 3600);
            return $value;
        // }

    }

    public static function ipMap($ip)
    {
        // global $memcache;

        // $slug = "ip-{$ip}";

        // $user = $memcache->get($slug);

        // if ($user) {
        //     return unserialize($user);
        // } else {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/{$ip}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $value = curl_exec($ch);
            curl_close($ch);

            // $memcache->set($slug, serialize($value), 3600);
            return $value;
        // }

    }

}
