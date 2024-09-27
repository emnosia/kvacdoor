<?php

class User {
    /**
     * The name of the database table containing user information.
     *
     * @var string
     */
    const TABLE = 'users';

    /**
     * Vérifie si l'utilisateur est authentifié
     *
     * @return bool True si l'utilisateur est authentifié, False sinon
     */
    public static function isAuthenticated()
    {
        return isset($_SESSION['user']['id']);
    }

    /**
     * Vérifie si l'utilisateur est banni
     * 
     * @param int|null $id L'ID de l'utilisateur à vérifier. Si null, utilise l'ID de l'utilisateur actuellement connecté
     * @return bool True si l'utilisateur est banni, False sinon
     */
    public static function isBanned(int $userId = null) : bool
    {
        if ($userId === null) {
            $userId = $_SESSION['user']['id'] ?? null;
        }
        if($userId === null) return false;

        $user = self::get($userId);
        return (bool)$user['ban'];
    }

    /**
     * Retrieves a user based on their ID, or the currently logged in user's ID if $userId is not specified
     *
     * @param int|null $userId The ID of the user to retrieve, or null to retrieve the currently logged in user
     * @return array The user's data
     */
    public static function get(int $userId = null)
    {
        return ($userId == null) ? $GLOBALS['DB']->GetContent(self::TABLE, ['id' => $_SESSION['user']['id']])[0] : $GLOBALS['DB']->GetContent('users', ['id' => $userId])[0];
    }

    /**
     * Retrieves all users
     *
     * @return array An array of all users
     */
    public static function getAll()
    {
        return $GLOBALS['DB']->GetContent(self::TABLE);
    }

    /**
     * Retrieves the $number most recently created, active, and unbanned accounts
     *
     * @param int $number The number of accounts to retrieve
     * @return array An array of the most recent accounts
     */
    public static function getAllRecent(int $number)
    {
        return $GLOBALS['DB']->GetContent(self::TABLE, ['active' => 1, 'ban' => 0], "ORDER BY created_at DESC LIMIT $number");
    }

    /**
     * Retrieves the total number of accounts
     *
     * @return int The number of accounts
     */
    public static function count()
    {
        return $GLOBALS['DB']->Count(self::TABLE);
    }

    /**
     * Checks if a user exists by their ID
     * 
     * @param int $user_id The ID of the user to check for existence
     * @return bool True if the user exists, False if they do not
     */
    public static function isExist($userId)
    {
        return ($GLOBALS['DB']->Count(self::TABLE, ["id" => $userId]) != 0);
    }

    /**
     * Returns the user's role
     * 
     * @param int $id The ID of the user
     * @return string The role of the user (User, Premium, Support, or Administrator)
     */
    public static function getUserRole(int $userId) : string
    {
        $role = self::get($userId)['roles'];

        switch ($role) {
        case 0:
            return 'User';
        case 1:
            return 'Premium';
        case 2:
            return 'Support';
        case 3:
            return 'Administrator';
        default:
            return 'Unknown';
        }
    }

    /**
     * Update the user's role
     * 
     * @param int $userId The user's ID.
     * @param int $role The new role for the user.
     */
    public static function setRole(int $userId, int $role)
    {
        $GLOBALS['DB']->Update(self::TABLE, ['id' => $userId], ['roles' => $role]);
    }

    /**
     * Update the Steam resolver offer (Xray) for a user
     * 
     * @param int $userId The ID of the user
     * @param string $state The new state to be set
     */
    public static function setSteamResolver($user_id, $state)
    {
        $GLOBALS['DB']->Update(self::TABLE, ['id' => $user_id], ['xray'=> $state]);
    }

    /**
     * Logout the current user
     */
    public static function logout()
    {
        session_unset();
        session_destroy();
    }

    public static function UserExistByDiscordID($discord_id)
    {
        return $GLOBALS['DB']->Count(self::TABLE, ["discord_id" => $discord_id]) != 0; 
    }

    static function GetUserByDiscordID($discord_id)
    {
        return $GLOBALS['DB']->GetContent(self::TABLE, ['discord_id' => $discord_id])[0]; 
    }

    public static function GetUserByEmail($email)
    {
        return $GLOBALS['DB']->GetContent(self::TABLE, ['email' => $email])[0]; 
    }

    /**
     * Update the last login time for a user
     * 
     * @param int $userId The ID of the user to update
     * @param int $timestamp The timestamp of the last login
     */
    public static function setLastLoginTime(int $userId, int $timestamp)
    {
        $GLOBALS['DB']->Update(self::TABLE, ['id' => $userId], ['last_login' => $timestamp, 'ip' => CSRF::GetVisitorIP(), 'user_agent' => $_SERVER['HTTP_USER_AGENT']]);
    }

    static function UpdateIP($user_id)
    {
        $GLOBALS['DB']->Update(self::TABLE, ['id' => $user_id], ['ip' => CSRF::GetVisitorIP()]);
    }

    /**
     * Update the ban status of a user in the database
     * 
     * @param int $userId The ID of the user to update
     * @param bool $state The new ban state of the user
     */
    public static function setBan(int $userId, bool $state)
    {
        $GLOBALS['DB']->Update(self::TABLE, ['id' => $userId], ['ban' => (int)$state]);
    }

    /**
     * @deprecated use get($userId) function
     */
    public static function GetUser($user_id = null)
    {
        return self::get($user_id);
    }

    /**
     * @deprecated use isAuthenticated() function
     */
    public static function isAuthentified()
    {
        return self::isAuthenticated();
    }

    /**
     * @deprecated use setBan() function
     */
    static function BanUser($user_id, $reason = null)
    {
        return self::setBan($user_id, true);
    }

    /**
     * @deprecated use setBan() function
     */
    static function UnbanUser($user_id)
    {
        return self::setBan($user_id, false);
    }

    /**
     * Get badges for a specific user
     *
     * @param int $userId The ID of the user to retrieve badges for
     * @return array An array of all badges associated with the specified user
     */
    public static function getUserBadge($user_id)
    {
        $db = $GLOBALS['DB']->getPdo();

        return $db->query("SELECT * FROM users_badges LEFT JOIN badges ON users_badges.badge_id = badges.id WHERE users_badges.user_id = {$user_id}")->fetchAll();
    }

}
