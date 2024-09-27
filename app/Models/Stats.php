<?php
class Stat
{

	static function SelectData($user_id, $date)
	{
		return $GLOBALS['DB']->GetContent('users_statistics', ['target_id' => $user_id, 'day' => $date])[0]['nbr'];
	}

	static function SelectLastData($user_id, $nbr = 5)
	{
		$data = $GLOBALS['DB']->GetContent('users_statistics', ['target_id' => $user_id], "ORDER BY id DESC LIMIT $nbr");
		return array_reverse($data);
	}

	static function MostData($date, $nbr = 5)
	{
		return $GLOBALS['DB']->GetContent('users_statistics', ['day' => $date], "ORDER BY nbr DESC LIMIT $nbr");
	}

	static function CountData($user_id)
	{
		return $GLOBALS['DB']->Count('users_statistics', ['target_id' => $user_id]);
	}

	static function InsertData($user_id, $data, $day)
	{
		$GLOBALS['DB']->Insert('users_statistics', ['target_id' => $user_id, 'nbr' => $data, 'day' => $day]);
	}

	static function UpdateData($user_id, $data, $day)
	{
		$GLOBALS['DB']->Update('users_statistics', ['target_id' => $user_id, 'day' => $day], ['nbr' => $data]);
	}

	static function ExistData($user_id, $day)
	{
		return ($GLOBALS['DB']->Count('users_statistics', ['target_id' => $user_id, 'day' => $day]) != 0);
	}

	static function IncrementeCompteur()
	{
		//$GLOBALS['DB']->Update("requests", [], ["compteur" => Stat::GetCompteur() + 1]);
	}

	static function GetCompteur()
	{
		return $GLOBALS['DB']->GetContent("requests")[0]["compteur"];
	}

}

class Chart
{

	public static function get(string $slug, string $time): array
	{
		return $GLOBALS['DB']->GetContent('servers_statistics', ['slug' => $slug, 'time' => $time])[0];
	}

	public static function getLast(string $slug, $number = 10)
	{
		$data = $GLOBALS['DB']->GetContent('servers_statistics', ['slug' => $slug], "ORDER BY updated_at DESC LIMIT $number");
		return array_reverse($data);
	}

	public static function count(string $slug)
	{
		return $GLOBALS['DB']->Count('servers_statistics', ['slug' => $slug]);
	}

	public static function add($slug, $value, $time)
	{
		$GLOBALS['DB']->Insert('servers_statistics', ['slug' => $slug, 'value' => $value, 'time' => $time]);
	}

	public static function update($slug, $value, $time)
	{
		$GLOBALS['DB']->Update('servers_statistics', ['slug' => $slug, 'time' => $time], ['value' => $value]);
	}

	// public static function delete($slug, $time)
	// {
	// 	$GLOBALS['DB']->query("DELETE FROM charts WHERE slug = ? AND time = ?", $slug, $time);
	// }

	public static function isExist($slug, $time)
	{
		return tmpcache("chart-exist-$slug-$time", ($GLOBALS['DB']->Count('servers_statistics', ['slug' => $slug, 'time' => $time]) != 0), 600);
	}
}
