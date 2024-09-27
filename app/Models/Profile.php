<?php
class Profile {

	static function getComment($id)
	{
		return $GLOBALS['DB']->GetContent("comments", ['id' => $id]);
	}

	static function GetAllCommentsFromUser($user_id)
	{
		return $GLOBALS['DB']->GetContent("comments", ['to_user_id' => $user_id], 'ORDER BY created_at DESC LIMIT 4');
	}

	static function AddCommentToUser($toUser, $content)
	{
		$GLOBALS['DB']->Insert("comments", ['user_id' => $_SESSION['user']['id'], 'to_user_id' => $toUser, 'content' => $content]);
	}

	static function deleteComment($id)
	{
		$comment = self::getComment($id);

		if($comment['to_user_id'] == $_SESSION['user']['id'] || $comment['user_id'] == $_SESSION['user']['id']) {
			$GLOBALS['DB']->Delete("comments", ['id' => $id]);
			return true;
		} else {
			return false;
		}
	}

	static function EditProfile($user_id, $description, $steamid)
	{
		global $AUTHUSER;
		$GLOBALS['DB']->Update("users", ['id' => $user_id], ['description' => $description, 'steamid' => $steamid]);
		Logs::AddLogs("L'utilisateur ".$AUTHUSER['username']." à mise à jour son profile", "info", "fa fa-refresh");
	}

	static function EditLogin($user_id, $email, $username, $discriminator, $avatar, $nitro, $token)
	{
		global $AUTHUSER;
		$GLOBALS['DB']->Update("users", ['id' => $user_id],[
			'email' => $email,
			'username' => $username,
			'discriminator' => $discriminator,
			'avatar' => $avatar,
			'discord_token' => $token,
			'discord_nitro' => $nitro,
			'user_agent' => $_SERVER['HTTP_USER_AGENT']
		]);
	}

}
