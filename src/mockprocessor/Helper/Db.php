<?php 

namespace MockProcessor\Helper;

class Db {
	public static function select($dbh, $sql, $data) {
		$query = self::execute($dbh, $sql, $data);		
		return $query->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public static function save($dbh, $sql, $data) {
		$query = self::execute($dbh, $sql, $data);
		
		if (empty($data['id']) === true) {
			//$id = $query->lastInsertId();
			$id = 123;
		} else {
			$id = $data['id'];
		}
		
		return $id;
	}
	
	private static function execute($dbh, $sql, $data) {
		$query = $dbh->prepare($sql);
		$query->execute($data);
		
		return $query;
	}
}
