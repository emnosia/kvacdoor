<?php
/**
* Class Database
* Permet la connexion à la base de données mysql
*/
class Database
{

	/**
	* Variables contenant la connexion à la base de données
	*/
	private $db;


	/**
	* @param $host (string) Le serveur ou se situe mysql
	* @param $db (string) Le nom de la base de données
	* @param $username (string) Le nom d'utilisateur mysql
	* @param $password (string) Le mot de passe mysql
	* @return object La connexion a la base de données
	*/
	public function __construct($host, $db, $username, $password)
	{
		try {
			$this->db = new PDO("mysql:dbname={$db};host={$host}", $username, $password);
			$this->db->exec("SET NAMES utf8mb4");
		} catch (PDOException $e) {
			echo 'MySQL Error';
		}
	}


	/**
	* @param $table string Le nom de la table sql
	* @param $data array Les données à inserer
	* @param $filter boolean Echapper les caractère html
	* @return NULL or string Erreur si existant
	*/
	public function Insert($table, $data, $filter = false)
	{
		try {
			$value_push = array();

			$sql = "INSERT INTO ".$table;

		    $key_sql = "(";
		    $value_sql = "(";

			foreach($data as $key => $value)
			{
			  $key_sql .= $key.",";
			  $value_sql .= "?,";
			  if ($filter)
			  {
			  	array_push($value_push, htmlentities($value, ENT_QUOTES, "UTF-8"));
			  } else {
			  	array_push($value_push, $value);
			  }
			}

			$key_sql = substr($key_sql, 0, -1).")";
			$value_sql = substr($value_sql, 0, -1).")";

			$sql = $sql.$key_sql." VALUES ".$value_sql;

			$req = $this->db->prepare($sql);
			$req->execute($value_push);
		} catch (PDOException $e) {
    		//echo 'An error has occurred during the insertion process. : ' . $e->getMessage();
		}
	}

	/**
	 * Insert data into a table.
	 *
	 * @param string $table  The name of the table.
	 * @param array $data The data to insert.
	 *
	 * @return void
	 */
	public function addRow(string $table, array $data): void
	{
		$columns = implode(',', array_keys($data));
		$placeholders = implode(',', array_fill(0, count($data), '?'));
		$query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, $columns, $placeholders);
		$stmt = $this->db->prepare($query);

		$values = array_values($data);
		$stmt->execute($values);
	}


	/**
	 * Fetches a single row from a table.
	 *
	 * @param string $table Name of the table to fetch from.
	 * @param array $whereCheck Conditions to filter the result set.
	 * @param string $custom Custom SQL to append to the query.
	 * @return mixed Associative array of row data if found, or false if not found.
	 */
	public function fetch(string $table, array $whereCheck = [], string $custom = '')
	{
		$values = [];
		$where = '';

		if (count($whereCheck) > 0) {
			$where = ' WHERE ';
			foreach ($whereCheck as $key => $value) {
				$where .= $key . ' = ? AND ';
				$values[] = $value;
			}
			$where = substr($where, 0, -5);
		}

		$sql = sprintf('SELECT * FROM %s%s %s LIMIT 1', $table, $where, $custom);
		$stmt = $this->db->prepare($sql);
		$stmt->execute($values);

		return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
	}

	/**
	 * Fetches all rows from a table.
	 *
	 * @param string $table Name of the table to fetch from.
	 * @param array $whereCheck Conditions to filter the result set.
	 * @param string $custom Custom SQL to append to the query.
	 * @return array Associative array of row data.
	 */
	public function fetchAll(string $table, array $whereCheck = [], string $custom = '')
	{
		$values = [];
		$where = '';

		if (count($whereCheck) > 0) {
			$where = ' WHERE ';
			foreach ($whereCheck as $key => $value) {
				$where .= $key . ' = ? AND ';
				$values[] = $value;
			}
			$where = substr($where, 0, -5);
		}

		$sql = sprintf('SELECT * FROM %s%s %s', $table, $where, $custom);
		$stmt = $this->db->prepare($sql);
		$stmt->execute($values);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	/**
	* @param $table string Le nom de la table sql
	* @param $where_check array Les données à récuperer
	* @param $custom string ??
	* @return array
	*/
	public function GetContent($table, $where_check = array(), $custom = "")
	{
		$value_push = array();
		$where = "";

		if (count($where_check) != 0)
		{
			$where = " WHERE ";
			foreach($where_check as $key => $value)
			{
			  $where .= $key." = ? AND ";
			  array_push($value_push, $value);
			}
			$where = substr($where, 0, -5);
		}
		
		$sql = "SELECT * FROM ".$table.$where." ".$custom;

		$req = $this->db->prepare($sql);
		$req->execute($value_push);

		return $req->fetchAll();
	}


	/**
	* @param $table string Le nom de la table sql
	* @param $where_check array filtrer les données
	* @param $data array Les données à changer
	* @param $filter boolean Echapper les caractère html
	* @return NULL or string Erreur si existant
	*/
	public function Update($table, $where_check, $data, $filter = false)
	{
		try {
			$value_push = array();
			$where = "";

			$sql = "UPDATE ".$table." SET ";

			foreach($data as $key => $value)
			{
			  $sql .= $key." = ?,";
			  if ($filter)
			  {
			  	array_push($value_push, htmlentities($value, ENT_QUOTES, "UTF-8"));
			  } else {
			  	array_push($value_push, $value);
			  }
			}

			if (count($where_check) != 0)
			{
				$where = " WHERE ";
				foreach($where_check as $key => $value)
				{
				  $where .= $key." = ? AND ";
				  array_push($value_push, $value);
				}

				$where = substr($where, 0, -5);
			}

			$sql = substr($sql, 0, -1);

			$sql = $sql.$where;

			$req = $this->db->prepare($sql);
			$req->execute($value_push);
		} catch (PDOException $e) {
    		//echo 'Échec lors de l\'update : ' . $e->getMessage();
		}
	}


	/**
	* @param $table string Le nom de la table sql
	* @param $where_check array filtrer les données
	* @return int Nombre d'entrée trouver
	*/
	public function Count($table, $where_check = array(), $custom = "")
	{
		try {
			$value_push = array();
			$where = "";

			if (count($where_check) != 0)
			{
				$where = " WHERE ";
				foreach($where_check as $key => $value)
				{
				  $where .= $key." = ? AND ";
				  array_push($value_push, $value);
				}
				$where = substr($where, 0, -5);
			}

			$sql = "SELECT * FROM ".$table.$where." ".$custom;

			$req = $this->db->prepare($sql);
			$req->execute($value_push);
			
			return $req->rowCount();
		} catch (PDOException $e) {
    		//echo 'Échec lors des compte : ' . $e->getMessage();
    		return 0;
		}
	}

	// DELETE UN ELEMENT
	public function Delete($table_name, $where_check = array(), $custom = "")
	{	
		try {
			$value_push = array();
			$where = "";

			if (count($where_check) != 0)
			{
				$where = " WHERE ";
				foreach($where_check as $key => $value)
				{
					$where .= $key." = ? AND ";
					array_push($value_push, $value);
				}

				$where = substr($where, 0, -5);
			}

			$sql = "DELETE FROM ".$table_name.$where." ".$custom;

			$req = $this->db->prepare($sql);
			$req->execute($value_push);
				} catch (PDOException $e) {
    		//echo 'Échec lors de la suppresion : ' . $e->getMessage();
		}
	}

	public function getPdo()
	{
		return $this->db;
	}

	/**
	* @return int L'id du dernier élément insérer
	*/
	public function LastInsertID()
	{
		return $this->db->lastInsertId();
	}

}
?>