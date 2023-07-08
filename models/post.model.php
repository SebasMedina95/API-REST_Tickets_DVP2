<?php 

require_once "connection.php";

class PostModel{

    /*=============================================
	Peticion para tomar los nombres de las columnas
	=============================================*/
	static public function getColumnsData($table, $database){
        //Esta consulta es especial, con COLUMN_NAME me traigo el los nombres de las columnas, casteo para convertir el resultado con el nombre item
        //y usando information_schema.columns uso el esquema de la columna donde el esquema de la base de datos table_schema corresponda al table_name
		return Connection::connect()
		->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
		-> fetchAll(PDO::FETCH_OBJ);

	}

	/*=============================================
	Peticion POST para crear datos de forma dinámica
	=============================================*/
	static public function postData($table, $data){
		
		$columns = "(";
		$params= "(";

		foreach ($data as $key => $value) {
			
            //Por que los key son los que me traen los nombres de las propiedades y concateno con ,
            //lo mismo aplica para los valores de parámetro, solo es que colocamos con : para enlace parámetros
			$columns .= $key.",";
			$params .= ":".$key.",";
			
		}

        //Quito las últimas comas que nos pueden quedar
		$columns = substr($columns, 0, -1);
		$params = substr($params, 0, -1);

		$columns .= ")";
		$params .= ")";

		$stmt = Connection::connect()->prepare("INSERT INTO $table $columns VALUES $params");

        //El enlace de los parámetros de forma dinámica
		foreach ($data as $key => $value) {
			
			$stmt->bindParam(":".$key, $data[$key], PDO::PARAM_STR);
			
		}

		try {
            
            if($stmt->execute()){

                return "El proceso POST dinámico fue realizado exitosamente!.";
    
            }

        } catch (\Throwable $th) {
            
            return "error";

        }

	}

}