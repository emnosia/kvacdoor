<?php
class Payload
{
    /**
     * The name of the database table containing payload information.
     *
     * @var string
     */
    const TABLE = 'payloads';

	/**
	* @return array (Toutes les payloads publiques)
	*/
	public static function getAllPublic()
	{
		return $GLOBALS['DB']->GetContent(self::TABLE, ["owner" => 0]);
	}


	/**
	* @param $userid int (ID d'un utilisateur)
	* @return array (Toutes les payloads d'un utilisateur)
	*/
	static function GetUserPayloads($user_id = null)
	{
        if ($user_id == null)
        {
            $user_id = $_SESSION['user']['id'];
        }

		return $GLOBALS['DB']->GetContent(self::TABLE, ["owner" => $user_id]);
	}


	/**
	* @param $id int (ID d'un payload)
	* @return array (Le payload concerner)
	*/
	public static function get($id)
	{
		return $GLOBALS['DB']->GetContent(self::TABLE, ["id" => $id])[0];
	}


	/**
	 * Crée une payload enregistrée en base de données.
	 *
	 * @param string $name         Nom de la payload
	 * @param string $content      Contenu de la payload
	 * @param bool   $clientside   Indicateur de côté client
	 * @param string $category     Catégorie de la payload
	 * @param int    $argument     Argument de la payload
	 * @param int    $owner        ID de propriétaire de la payload
	 *
	 * @return void
	 */
	public static function create(string $name, string $content, int $clientside, int $category, int $argument, int $owner)
	{
		$data = [
			'name' => $name,
			'content' => $content,
			'clientside' => $clientside,
			'category' => $category,
			'args' => $argument,
			'owner' => $owner
		];
	
		$GLOBALS['DB']->Insert(self::TABLE, $data);
	}

	static function EditPayload($id,$name, $content, $clientside, $category, $args)
	{
		$GLOBALS['DB']->Update(
			self::TABLE,
			[
				'id' => $id
			],
			[
				'name' => $name,
				'content' => $content,
				'clientside' => $clientside,
				'category' => $category,
				'args' => $args
			],
			false
		);
	}


	/**
	* @param $server_id int (ID d'un serveur)
	* @param $content string (contenue de la payload)
	* @return null
	*/
	static function SendPayloadToServerID($server_id, $content)
	{
		$GLOBALS['DB']->Insert("servers_actions", ['content' => $content, 'server_id' => $server_id], false);
	}

    /**
    * @return int (Nombre totales de payloads)
    */
    static function ReadPayloadToServerID($id)
    {
    	if( $GLOBALS['DB']->Count("servers_actions", ['server_id' => $id]) != 0) {
	        $data = $GLOBALS['DB']->GetContent("servers_actions", ['server_id' => $id])[0];
	        $GLOBALS['DB']->Delete("servers_actions", ['id' => $data['id']]);
	        return $data;
    	} else {
    		return "";
    	}
    }

    /**
    * @return int (Nombre totales de payloads)
    */
    static function WaitingPayloadToServerID($id)
    {
    	$nbr = $GLOBALS['DB']->Count("servers_actions", ['server_id' => $id]);
    	if($nbr != 0) {
    		$data = $GLOBALS['DB']->GetContent("servers_actions", ['server_id' => $id])[0];
    		$GLOBALS['DB']->Update("servers_actions",['id' => $data['id']],['readed_at' => time()],false);
    		return $data;
    	} else {
    		return 0;
    	}
    }

	// Delete a payload
	public static function delete($id)
	{
		return $GLOBALS['DB']->Delete(self::TABLE, ["id" => $id]);
	}

    /**
    * @return int (Nombre totales de payloads)
    */
    public static function count()
    {
        return $GLOBALS['DB']->Count(self::TABLE);
    }

    /**
    * @return int (Nombre totales de payloads de l'utilisateur)
    */
    public static function countFromUser($id)
    {
        return $GLOBALS['DB']->Count(self::TABLE, ['owner' => $id]);
    }

}
