<?php 

require_once "connection.php";

class PutModel{

	/*=============================================
	Peticion PUT para editar datos de forma dinámica
	=============================================*/

	static public function putData($table, $data, $id, $nameId){

        //Para almacenar el SET de la sentencia UPDATE
		$set = "";

        //Almaceno el nombre del campo y coloco la estrucutra de enlace para que quede dinámica
		foreach ($data as $key => $value) {
			
			$set .= $key." = :".$key.",";
				
		}

        //Remuevo la última ,
		$set = substr($set, 0, -1);

		$stmt = Connection::connect()->prepare("UPDATE $table SET $set WHERE $nameId = :$nameId");

        //Enlazo los cambos de forma dinámica
		foreach ($data as $key => $value) {
			
			$stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
			
		}		

        //Enlazo el campo ID aparte que con ese editaré, selecciono la row específica
		$stmt->bindParam(":".$nameId, $id, PDO::PARAM_INT);

		try {
            
            if($stmt->execute()){

                return "El proceso PUT dinámico fue realizado exitosamente!.";
    
            }

        } catch (\Throwable $th) {
            
            return "error";

        }

	}

}