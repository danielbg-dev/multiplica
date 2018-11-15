<?php
//operaciones.php
include("nusoap.php");

define('DIVISION', 1);
define('MULTIPLICACION', 2);
define('SUMA', 3);
define('RESTA', 4);
define('POTENCIA', 5);

if (isset($_POST['operacion'])){
	
	if( intval($_POST['operacion']) == DIVISION ){
		operacion_division();
	} else if ( intval($_POST['operacion']) == MULTIPLICACION ) {
		operacion_multiplicacion();

	} else if ( intval($_POST['operacion']) == SUMA ) {
		operacion_suma();

	}else if ( intval($_POST['operacion']) == RESTA ) {
		operacion_resta();

	}else{
		echo json_encode("No implementada");	
	}
	
} else {
	echo "CGI que recibe la llamada a operaciones de microservicios por metodo POST";	
}


function operacion_division(){
	$cliente = new nusoap_client("http://132.248.63.140/ms/server.php?wsdl",'wsdl');	
	$error = $cliente->getError();

    if ($error) {
        echo json_encode($error);
    } else {
	    $datos = array(
	        'username' => 'admin',
	        'password' => '9542931e640c671a60ea44a954b249c179da1239',	        
	    );

	    $result = $cliente->call("division", array(
	    	"numeros" => "12, 2",
	        "datos" => json_encode($datos)	        
	    ));

	    if (!empty($result)) {
	    	echo ($result);
	    } else {
	    	echo json_encode("NO");	
	    }

    }	
}

function operacion_multiplicacion(){

	$cliente = new nusoap_client("http://132.248.63.140/ms/server.php?wsdl",'wsdl');	
	$error = $cliente->getError();

    if ($error) {
        echo json_encode($error);
    } else {
	    $datos = array(
	        'username' => 'admin',
	        'password' => '9542931e640c671a60ea44a954b249c179da1239',
	        'idregistro' => 6
	    );

	    $result = $cliente->call("multiplicacion", array(
	    	"numeros" => "12, 2",
	        "datos" => json_encode($datos)	        
	    ));

	    if(!empty($result)){
	    	echo ($result);
	    } else {
	    	echo json_encode("NO");	
	    }

    }	
}

function operacion_suma(){
	 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://132.248.63.20/sitio2/public/index.php/suma");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);

        $data = array(
            'user' => 'user',
            'password' => '12345',
            'a' => '12',
            'b' => '2',
        );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        echo $output;
}

function operacion_resta(){
	$cliente = new nusoap_client("http://132.248.63.141/sitio1/phpmicroservices/server.php?wsdl");
	$error = $cliente->getError();

    if ($error) {
        echo json_encode($error);
    } else {	  
		$datos = array('datos'=> json_encode(array(
			'username' => 'karla',
			'password' => '1234',
			'num1' => 12,
			'num2' => 2))
		);
	    $result = $cliente->call("resta",  $datos);
	    if (!empty($result)) {
	    	echo ($result);
	    } else {
	    	echo json_encode("NO");	
	    }
    }
}
