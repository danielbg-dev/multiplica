<?php
    include("nusoap.php");

    function conectar()
    {
        try{
            $s = new PDO('mysql:host=127.0.0.1; dbname=pruebas', "root", 
                "12345678", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
            return $s;
        }catch(PDOException $e) {
            echo 'Falló la Conexión: '.$e->getMessage();
        }
    }

    /**
    $datos['password']
    $datos['username']
    */
    function login($datos)
    {
        $conn = conectar();
        
        try{
            $query = sprintf("SELECT * FROM login WHERE password='%s' AND username='%s'",$datos['password'],$datos['username']);
            $result = $conn->query($query);
            if ($result->fetchColumn() > 0)
            {
                $aux['error'] = ""; //Mensaje de Exito
                $aux['code'] = "0"; //Código de Exito
            }
            else
            {
                $aux['error'] = "¡Datos de Acceso Equivocados!"; 
                $aux['code'] = "-1";                
            }
            $conn = null; //Para cerrar la conexión a la base de datos.
            return $aux;
        }catch(PDOException $e) {
            $aux['error'] = $e->getMessage(); //Mensaje de Error en la Consulta
            $aux['code'] = "-2"; //Error de Consulta            
            $conn = null; //Para cerrar la conexión a la base de datos.
            return $aux;
        }
    }
      
    function consultar($id)
    {
        $conn = conectar();
        
        try{
            $query = sprintf("SELECT * FROM registros WHERE idregistros=%d LIMIT 1",(int)$id);
            $result = $conn->query($query);
            if ($result->rowCount() > 0)
            {
                while($row = $result->fetch())
                {
                    $aux['datos'] = array(
                        'nombre'=>$row['nombre'],
                        'apePat'=>$row['apePat'],
                        'apeMat'=>$row['apeMat'],
                        'domicilio'=>$row['domicilio'],
                        'genero'=>$row['genero']
                    );
                }
                $aux['error'] = ""; //Mensaje de Error
                $aux['code'] = "0"; //Código de Exito
            }
            else
            {
                $aux['datos'] = "";
                $aux['error'] = "¡No hay registro con ese ID!"; 
                $aux['code'] = "-1";                
            }
        }catch(PDOException $e) {
            $aux['datos'] = "";
            $aux['error'] = $e->getMessage(); //Mensaje de Error en la Consulta
            $aux['code'] = "-2"; //Error de Consulta            
        }

        return $aux;
        $conn = null; //Para cerrar la conexión a la base de datos.        
    }

    function obtenerRegistros($datos) 
    {
        $datos = json_decode($datos, TRUE);

        $login = login($datos);

        //return json_encode($login);

        if ($login['code']=="0")
        {
            $respuesta['datos'] = consultar($datos['idregistro']);
            $respuesta['codigo'] = "0";
            $respuesta['mensaje'] = "";
        }
        else if ($login['code']=="-1")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-1";
            $respuesta['mensaje'] = $login['error'];
        }
        else if ($login['code']=="-2")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-2";
            $respuesta['mensaje'] = $login['error'];            
        }

        return json_encode($respuesta);            
    }

    function consultarNombre($datos)
    {
        return json_encode($datos . ", hermano ya eres mexicano!");
    }


    /**
    Este es el chido de la división
    */
    function logicaProcesaPeticionDivision($numeros, $datos) 
    {
        $datos = json_decode($datos, TRUE);
        $login = login($datos);

        if ($login['code']=="0")
        {
            $respuesta['datos'] = dividir($numeros);
            $respuesta['codigo'] = "0";
            $respuesta['mensaje'] = "";
        }
        else if ($login['code']=="-1")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-1";
            $respuesta['mensaje'] = $login['error'];
        }
        else if ($login['code']=="-2")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-2";
            $respuesta['mensaje'] = $login['error'];            
        }

        return json_encode($respuesta);            
    }

    /**
    Este es el chido de la división
    */
    function logicaProcesaPeticionMultiplicacion($numeros, $datos) 
    {
        $datos = json_decode($datos, TRUE);
        $login = login($datos);

        if ($login['code']=="0")
        {
            $respuesta['datos'] = multiplicar($numeros);
            $respuesta['codigo'] = "0";
            $respuesta['mensaje'] = "";
        }
        else if ($login['code']=="-1")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-1";
            $respuesta['mensaje'] = $login['error'];
        }
        else if ($login['code']=="-2")
        {
            $respuesta['datos'] = "";
            $respuesta['codigo'] = "-2";
            $respuesta['mensaje'] = $login['error'];            
        }

        return json_encode($respuesta);            
    }

    function dividir($numeros) {
        $arreglo = explode(",", $numeros);
        $resultado = "";
        foreach($arreglo as $num) {
            if(empty($resultado)){
                if(floatval($num) != 0){
                    $resultado = floatval($num);    
                }                
            } else {
                if(floatval($num) != 0){
                    $resultado /= floatval($num);    
                }
            }
            
        }
        return json_encode($resultado);        
    }

    function multiplicar($numeros){
        $arreglo = explode(",", $numeros);
        $resultado = "";
        foreach($arreglo as $num) {
            if(empty($resultado)){
                if(floatval($num) != 0){
                    $resultado = floatval($num);    
                }                
            } else {
                if(floatval($num) != 0){
                    $resultado *= floatval($num);    
                }
            }
            
        }
        return json_encode($resultado);            
    }

    function division($numeros, $datos) {        
        return logicaProcesaPeticionDivision($numeros, $datos);
    }

    function multiplicacion($numeros, $datos) {        
        return logicaProcesaPeticionMultiplicacion($numeros, $datos);    
    }
      
    $server = new soap_server();
    $server->configureWSDL("registros", "urn:registros");

    $server->register("obtenerRegistros",
        array("datos" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:registros",
        "urn:registros#obtenerRegistros",
        "rpc",
        "encoded",
        "Propociona los registros de una tabla");

    $server->register("division",
        array("numeros" => "xsd:string", "datos" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:registros",
        "urn:registros#division",
        "rpc",
        "encoded",
        "Divide números");

    $server->register("multiplicacion",
        array("numeros" => "xsd:string", "datos" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:registros",
        "urn:registros#multiplicacion",
        "rpc",
        "encoded",
        "Multiplica números");


    //$server->configureWSDL("registros", "urn:registros");
    $server->register("consultarNombre",
        array("datos" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:registros",
        "urn:registros#consultarNombre",
        "rpc",
        "encoded",
        "Consulta el Nombre");


    $server->service($HTTP_RAW_POST_DATA);

?>