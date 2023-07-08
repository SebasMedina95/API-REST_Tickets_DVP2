<?php 


class PostController{

    /*=============================================
	Peticion para tomar los nombres de las columnas
	=============================================*/
	static public function getColumnsData($table, $database){

		$response = PostModel::getColumnsData($table, $database);
		return $response;
	
	}

	/*=============================================
	Peticion POST para crear datos
	=============================================*/
	public function postData($table, $data){

		$response = PostModel::postData($table, $data);

		$return = new PostController();
		$return -> fncResponse($response, "postData", "Se insertó exitosamente un ticket");

	}


    /*=============================================
    ***********************************************
	RESPUESTAS DEL CONTROLADOR
    ***********************************************
	=============================================*/
    public function fncResponse($response, $method, $description){

		if(!empty($response) && $response != "error"){

			$json = array(
				'status' => 200,
				"results" => $response,
                "method" => $method,
                "description" => $description
			);

		}else{

            if($response == "error"){
                $json = array(
                    'status' => 500,
                    "results" => "No Encontrado",
                    "method" => $method,
                    "results" => "Una o mas columnas enviadas no coinciden en la base de datos"
                );

            }else{

                $json = array(
                    'status' => 404,
                    "results" => "No Encontrado",
                    "method" => $method,
                    "results" => $response
                );

            }

		}

		echo json_encode($json, http_response_code($json["status"]));
		return;

	}

}