<?php

class MySQL{

	private static $conn;
	private static $dbname = "db574214884";
	private static $servername = "db574214884.db.1and1.com";
	private static $username = "dbo574214884";
	private static $password = "";

	// Se connecte à la base de données
	public static function init(){
		try{
			self::$conn = new PDO("mysql:host=".self::$servername.";dbname=".self::$dbname, self::$username, self::$password);
			// Applique l'interclassement utf8 par défaut
			self::$conn->exec("set names utf8");
			// set the PDO error mode to exception
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo "Connection failed: " . $e->getMessage();
			exit();
		}
	}


	// Insère des données dans la table demandée
	public static function insert_data($table,$names,$datas){
		$sql = "INSERT INTO ". $table ." (";
		foreach ($names as $name) {$sql = $sql.$name.",";}
		$sql = substr($sql,0,-1).") VALUES (";
		foreach ($datas as $data) {$sql = $sql."'".$data."',";}
		$sql = substr($sql,0,-1).")";
		return self::$conn->exec($sql);
	}


	// Supprime les données specifiées
	public static function delete_data($table,$cond){
		$sql = "DELETE FROM ". $table . " WHERE ".$cond;
		return self::$conn->exec($sql);
	}


	// Selectionne des données
	public static function select_data($table,$names,$cond){
		$sql = "SELECT ";
		foreach ($names as $name) {$sql = $sql.$name.",";}
		if($cond==''){$sql = substr($sql,0,-1)." FROM ".$table;}
		else{$sql = substr($sql,0,-1)." FROM ".$table." WHERE ".$cond;}
		$statement = self::$conn->prepare($sql);
		$statement->execute();
		$result = $statement->setFetchMode(PDO::FETCH_ASSOC);
		$res = $statement->fetchAll();
		return $res;
	}


	// Compte le nombre d'entrées
	public static function count_data($table,$cond){
		if($cond==''){$sql = "SELECT COUNT(*) FROM ".$table;}
		else{$sql = "SELECT COUNT(*) FROM ".$table." WHERE ".$cond;}
		return self::$conn->query($sql)->fetchColumn();
	}


	// Modifie les données specifiées
	public static function update_data($table,$names,$datas,$cond){
		$sql = "UPDATE ". $table ." SET ";
		foreach ($names as $key => $name) {
			$sql = $sql.$name."='".$datas[$key]."', ";
		}
		$sql = substr($sql,0,-2)." WHERE ".$cond;
		$statement = self::$conn->prepare($sql);
		$statement->execute();
	}

}