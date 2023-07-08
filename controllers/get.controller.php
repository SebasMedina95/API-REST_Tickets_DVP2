<?php 

class GetController {

    /*=============================================
	Peticiones GET sin filtro
	=============================================*/
	public function getData($table, $orderBy, $orderMode, $startAt, $endAt){

        $response = GetModel::getData($table, $orderBy, $orderMode, $startAt, $endAt);

		$return = new GetController();
        $return -> fncResponse($response, "getData()", "Obteniendo los datos de la BD << SIN >> filtros");

	}

    /*=============================================
	Peticiones GET con filtro
	=============================================*/
	public function getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        $response = GetModel::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

		$return = new GetController();
        $return -> fncResponse($response, "getFilterData()", "Obteniendo los datos de la BD << CON >> filtros");

	}




    /*=============================================
    ***********************************************
	RESPUESTAS DEL CONTROLADOR
    ***********************************************
	=============================================*/
    public function fncResponse($response, $method, $description){

		if(!empty($response)){

			$json = array(
				'status' => 200,
				'total' => count($response),
				"results" => $response,
                "method" => $method,
                "description" => $description
			);

		}else{

			$json = array(
				'status' => 404,
				"results" => "No Encontrado",
                "method" => $method,
                "results" => $response
			);

		}

		echo json_encode($json, http_response_code($json["status"]));
		return;

	}

}