<?php 

require_once "connection.php";

class GetModel{

    /*=============================================
	Peticiones GET sin filtro
	=============================================*/
	static public function getData($table, $orderBy, $orderMode, $startAt, $endAt){
            
        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY $orderBy $orderMode");

		}else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
		
		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table");

		}
        
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_CLASS);
	}

    /*=============================================
	Peticiones GET con filtro
	=============================================*/
	static public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
        
        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $linkTo LIKE '%$equalTo%' ORDER BY $orderBy $orderMode");
		
		}else if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $linkTo LIKE '%$equalTo%' ORDER BY $orderBy $orderMode LIMIT $startAt, $endAt");
		
		}else{

			$stmt = Connection::connect()->prepare("SELECT * FROM $table WHERE $linkTo LIKE '%$equalTo%'");

		}
        
        $stmt -> execute();
        return $stmt -> fetchAll(PDO::FETCH_CLASS);

	}

}