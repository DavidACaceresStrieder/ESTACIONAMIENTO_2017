<?php

require_once "vendor/autoload.php";

$app = new \Slim\Slim();

$app->POST('/IngresarAuto', function() use($app) {	
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=Estacionamiento","root","");
        }catch(PDOExeption $e){
            echo '<script language="javascript">alert("Falla en conectar a la DB");</script>'; 
        }

        $valColor = $app->request->post("Color");
        $valDate = date("Y-m-d H:i:s");
        $valPatente = $app->request->post("Patente");
        $valPiso = $app->request->post("Piso");
        $valNumero = $app->request->post("id_cochera");
        $valMarca = $app->request->post("Marca");
        $valDiscapacitado = $app->request->post("Discapacidad");

        //Validar la discapacidad de el estacionamiento y el id de donde va el auto

         $consulta = $pdo->prepare("INSERT INTO estacionamientos(Patente,Color,Marca,Horario,_id,Discapacidad,Piso) VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
         $consulta->bindValue(":p1",$valPatente);
         $consulta->bindValue(":p2",$valColor);
         $consulta->bindValue(":p3",$valMarca);
         $consulta->bindValue(":p4",$valDate);
         $consulta->bindValue(":p5",$valNumero);
         $consulta->bindValue(":p6",$valDiscapacitado);
         $consulta->bindValue(":p7",$valPiso);

         $consulta->execute();

});


$app->POST('/EgresarAuto', function() use($app) {	
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=Estacionamiento","root","");
        }catch(PDOExeption $e){
            echo '<script language="javascript">alert("Falla en conectar a la DB");</script>'; 
        }

        $valColor = $app->request->post("Color");
        $valDate = date("Y-m-d H:i:s");
        $valPatente = $app->request->post("Patente");
        $valPiso = $app->request->post("Piso");
        $valNumero = $app->request->post("id_cochera");
        $valMarca = $app->request->post("Marca");
        $valDiscapacitado = $app->request->post("Discapacidad");

        //Validar la discapacidad de el estacionamiento y el id de donde va el auto

         $consulta = $pdo->prepare("INSERT INTO estacionamientos(Patente,Color,Marca,Horario,_id,Discapacidad,Piso) VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
         $consulta->bindValue(":p1",$valPatente);
         $consulta->bindValue(":p2",$valColor);
         $consulta->bindValue(":p3",$valMarca);
         $consulta->bindValue(":p4",$valDate);
         $consulta->bindValue(":p5",$valNumero);
         $consulta->bindValue(":p6",$valDiscapacitado);
         $consulta->bindValue(":p7",$valPiso);

         $consulta->execute();

});


//IMPLEMENTAR INSTRUCCIONES GET, POST, PUT, DELETE
//$app->METODO('/RUTEO', CALL_BACK);

$app->run();
?>