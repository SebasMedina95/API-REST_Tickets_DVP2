<?php 

class DeleteController{

	/*=============================================
	Peticiones GET con filtro
	=============================================*/
	static public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

		$response = GetModel::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
		return $response;

	}

    /*=============================================
	Peticion DELETE para borrar datos
	=============================================*/
	public function deleteData($table, $id, $nameId){

		$response = deleteModel::deleteData($table, $id, $nameId);

		$return = new DeleteController();
		$return -> fncResponse($response, "deleteData", "Se eliminó exitosamente un ticket");

	}

	/*=============================================
	Respuestas del controlador
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