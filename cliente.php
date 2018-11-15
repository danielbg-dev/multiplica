<?php
    include("nusoap.php");

    $cliente = new nusoap_client("http://172.18.0.1/server.php?wsdl",'wsdl');
      
    $error = $cliente->getError();

    if ($error) 
    {
        echo "<strong>Error desde la apertura</strong>".$error;
    }
      
    $datos = array(
        'username' => 'admin',
        'password' => '9542931e640c671a60ea44a954b249c179da1239',
        'idregistro' => 6
    );

    $result = $cliente->call("division", array(
        "datos" => json_encode($datos),
        "numeros" => "12, 2"
    ));

    $resultMult = $cliente->call("multiplicacion", array(
        "datos" => json_encode($datos),
        "numeros" => "12, 2"
    ));
          
    if ($cliente->fault) {
        echo "Fault: ";
        echo $result;
    } else {
        $error = $cliente->getError();
        if ($error) {
            echo "Error " . $error;
        }
        else {
            echo "Resultado de Consulta: <br/>";
            echo $result;
        }
    }
?>
