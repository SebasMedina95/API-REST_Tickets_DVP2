<?php

//Para sacar de la URL la tabla que se está consultando.
$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);
$routesDomain = $_SERVER['HTTP_HOST'];


if (count($routesArray) == 1) {

    $json = array(
        'status' => 404,
        "results" => "No encontrado",
        "message" => "No se especificó la tabla de la base de datos"
    );

    echo json_encode($json, http_response_code($json["status"]));
    return;
} else {


    /*=============================================
	PETICIÓN GET
	=============================================*/
    if (count($routesArray) == 2 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "GET"
    ) {

        /*=============================================
        MOSTRAMOS INFORMACIÓN CON FILTRO
        =============================================*/
        if(isset($_GET["linkTo"]) && isset($_GET["equalTo"])){

            /*=============================================
            Preguntamos si viene variables de orden
            =============================================*/
            //Si viene elementos para ordenamiento
            if(isset($_GET["orderBy"]) && isset($_GET["orderMode"])){

                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];

            }else{

                $orderBy = null;
                $orderMode = null;

            }

            /*=============================================
            Preguntamos si viene variables de límite
            =============================================*/
            if(isset($_GET["startAt"]) && isset($_GET["endAt"])){

                $startAt = $_GET["startAt"];
                $endAt = $_GET["endAt"];

            }else{

                $startAt = null;
                $endAt = null;

            }

            $response = new GetController();
            //En la URL vendría las variables GET, necesito separar con el ? que indica los parámetros y  dejar independizado el nombre de la tabla de las variables GET
            $response -> getFilterData(explode("?" , $routesArray[2])[0], $_GET["linkTo"], $_GET["equalTo"], $orderBy, $orderMode, $startAt, $endAt);
        
        }else{

            /*=============================================
            MOSTRAMOS INFORMACIÓN SIN FILTRO
            =============================================*/
            if (isset($_GET["orderBy"]) && isset($_GET["orderMode"])) {

                $orderBy = $_GET["orderBy"];
                $orderMode = $_GET["orderMode"];

            } else {

                $orderBy = null;
                $orderMode = null;

            }

            /*=============================================
            Preguntamos si viene variables de límite
            =============================================*/
            if (isset($_GET["startAt"]) && isset($_GET["endAt"])) {

                $startAt = $_GET["startAt"];
                $endAt = $_GET["endAt"];

            } else {

                $startAt = null;
                $endAt = null;

            }

            $response = new GetController();
            //En la URL vendría las variables GET, necesito separar con el ? que indica los parámetros y  dejar independizado el nombre de la tabla de las variables GET
            $response->getData(explode("?", $routesArray[2])[0], $orderBy, $orderMode, $startAt, $endAt);

        } 

       
    }

    /*=============================================
	Peticiones POST
	=============================================*/
    if (count($routesArray) == 2 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "POST"
    ) {

         /*=============================================
		Traemos el listado de columnas de la tabla a cambiar
		=============================================*/
        //Para guardar las columnas en un array y traigo el nombre de la bd
        $columns = array();	
		$database = RoutesController::database();

        //Buscamos los nombres de columna, el model se encargará de esta parte
        $response = PostController::getColumnsData(explode("?", $routesArray[2])[0], $database);

        foreach ($response as $key => $value) {

			array_push($columns, $value->item); //Recordemos en item es la llave que tiene el nombre de columnas
	
		}

        /*=============================================
		Quitamos el primer y ultimo indice de las columnas
        recordemos que no nos interesa el id y el date timestamp ya que ellos se ajustan automaticamente.
		=============================================*/
		array_shift($columns); //quito primero
		array_pop($columns);   //quito último

        /*=============================================
		Recibimos las valores POST
		=============================================*/

		if(isset($_POST)){

            /*=============================================
			Validamos que las variables de los campos POST coincidan con los nombres de columnas de la base de datos
			=============================================*/
            $count = 0;

            //Usamos array_keys que es la función que me permite llegar a las propiedades del arreglo a recorrer
			foreach (array_keys($_POST) as $key => $value) {
				
                //Se incremenda dado el caso de coincidencia
				$count = array_search($value, $columns);		
			
			}

            if($count > 0){

                /*=============================================
                Solicitamos respuesta del controlador para crear datos en cualquier tabla
                =============================================*/	
                $response = new PostController();
                $response -> postData(explode("?", $routesArray[2])[0], $_POST);

            }else{

                $json = array(
                    'status' => 400,
                    'results' => "Error: Los campos no coinciden con los de la base de datos"
               );

               echo json_encode($json, http_response_code($json["status"]));
               return;

            }


        }
    }

    /*=============================================
	Peticiones PUT
	=============================================*/
    if (count($routesArray) == 2 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "PUT"
    ) {

        /*=============================================
		Preguntamos si viene ID
		=============================================*/
		if(isset($_GET["id"]) && isset($_GET["nameId"])){

            /*=============================================
			Validamos que exista el ID
            Preguntamos primero para traer la información
			=============================================*/
			$table = explode("?", $routesArray[2])[0];
			$linkTo = $_GET["nameId"];
			$equalTo = $_GET["id"];
			$orderBy = null;
			$orderMode = null;
			$startAt = null;
			$endAt = null;

            //Usemos el getFilterData de POST, pero ajustemos el controlador en el PutController para este caso
			$response = PutController::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

            if($response){

                /*=============================================
				Capturamos los datos del formulario
				=============================================*/
				$data = array();
                //Convirtamos en un string el contenido que venga desde las entradas de PHP y lo adapto al array data definido
				parse_str(file_get_contents('php://input'), $data);

                /*=============================================
				Traemos el listado de columnas de la tabla a cambiar
				=============================================*/
				$columns = array();
				$database = RoutesController::database();
				$response = PostController::getColumnsData(explode("?", $routesArray[2])[0], $database);
				
				foreach ($response as $key => $value) {

					array_push($columns, $value->item);
			
				}

				array_shift($columns);
				array_pop($columns);

				$count = 0;

				foreach (array_keys($data) as $key => $value) {
					
					$count = array_search($value, $columns); // Encontrando coincidencias					
				
				}

                if($count > 0){

                    $response = new PutController();
                    $response -> putData(explode("?", $routesArray[2])[0], $data, $_GET["id"], $_GET["nameId"]);

                }else{

                    $json = array(
                        'status' => 400,
                        'results' => "Error: Los campos no coinciden con los de la base de datos"
                    );

                    echo json_encode($json, http_response_code($json["status"]));
                    return;
                    
                }       
                
            }else{

                $json = array(
                    'status' => 404,
                    'results' => "No se encontró el ID, no se realiza acción"
                );

                echo json_encode($json, http_response_code($json["status"]));
                return;

            }

        }
    }

    /*=============================================
	Peticiones DELETE
	=============================================*/
    if (count($routesArray) == 2 &&
        isset($_SERVER["REQUEST_METHOD"]) &&
        $_SERVER["REQUEST_METHOD"] == "DELETE"
    ) {

        
        /*=============================================
		Preguntamos si viene ID
		=============================================*/
		if(isset($_GET["id"]) && isset($_GET["nameId"])){

            /*=============================================
			Validamos que exista el ID
            Preguntamos primero para traer la información
			=============================================*/
			$table = explode("?", $routesArray[2])[0];
			$linkTo = $_GET["nameId"];
			$equalTo = $_GET["id"];
			$orderBy = null;
			$orderMode = null;
			$startAt = null;
			$endAt = null;

			$response = DeleteController::getFilterData($table, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

            if($response){

                /*=============================================
				Capturamos los datos del formulario
				=============================================*/
				$data = array();
                //Convirtamos en un string el contenido que venga desde las entradas de PHP y lo adapto al array data definido
				parse_str(file_get_contents('php://input'), $data);

                /*=============================================
				Traemos el listado de columnas de la tabla a cambiar
				=============================================*/
				$columns = array();
				$database = RoutesController::database();
				$response = PostController::getColumnsData(explode("?", $routesArray[2])[0], $database);
				
				foreach ($response as $key => $value) {

					array_push($columns, $value->item);
			
				}

				array_shift($columns);
				array_pop($columns);

				$count = 0;

				foreach (array_keys($data) as $key => $value) {
					
					$count = array_search($value, $columns); // Encontrando coincidencias					
				
				}

                if($count > 0){

                    $response = new DeleteController();
                    $response -> deleteData(explode("?", $routesArray[2])[0], $_GET["id"], $_GET["nameId"]);

                }else{

                    $json = array(
                        'status' => 400,
                        'results' => "Error: Los campos no coinciden con los de la base de datos"
                    );

                    echo json_encode($json, http_response_code($json["status"]));
                    return;
                    
                }       
                
            }else{

                $json = array(
                    'status' => 404,
                    'results' => "No se encontró el ID, no se realiza acción"
                );

                echo json_encode($json, http_response_code($json["status"]));
                return;

            }

        }
        
    }

    // $json = array(
    //     'status' => 200,
    //     'result' => 'Comunicación exitosa!',
    //     'local' => $routesDomain,
    //     'api' => $routesArray[1],
    //     'table' => $routesArray[2],
    // );

    // echo json_encode($json);
    // return;

}
