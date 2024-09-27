<?php
class Category
{

	/**
	* @param $id int (ID de la catégorie)
	* @return array (la catégorie selectionner)
	*/
	public static function get($categoryId)
	{
		return $GLOBALS['DB']->GetContent("payloads_categories", ["id" => $categoryId])[0];
	}

	/**
	* @return array (Toutes les categories)
	*/
	public static function getAll()
	{
		return tmpcache("payloads-categories", $GLOBALS['DB']->GetContent("payloads_categories"), 3600);
	}

}
