<?php

require_once "vendor/autoload.php";

$app = new \Slim\Slim();

$app->POST('/IngresarAuto', function() use($app) {	
        $Error=False;
        $DisponibilidadDiscapasitados=0;

        $valColor = $app->request->post("Color");
        $valDate = date("Y-m-d H:i:s");
        $valPatente = $app->request->post("Patente");
        $valPiso = $app->request->post("Piso");
        $valNumero = $app->request->post("id_cochera");
        $valMarca = $app->request->post("Marca");
        $valDiscapacitado = $app->request->post("Discapacidad");

        try{
            $pdo = new PDO("mysql:host=localhost;dbname=Estacionamiento","root","");
        }catch(PDOExeption $e){
            echo '<script language="javascript">alert("Falla en conectar a la DB");</script>'; 
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       
        $Insertar = $pdo->prepare("INSERT INTO estacionamientos(Patente,Color,Marca,Horario,_id,Discapacidad,Piso) VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $Consulta = $pdo->prepare('SELECT * FROM estacionamientos'); 
        
        $Consulta->execute();
        $Resultaado = $Consulta->fetchAll();

        foreach($Resultaado as $row){
            if($row["Patente"]==$valPatente){
                $Error = TRUE;
                $Mensaje = "Ya hay un auto ingresado con esta patente";
                break;
            }
            if($row["Discapacidad"]==True){
                $DisponibilidadDiscapasitados++;
            }
            if($row["_id"]==$valNumero){
                $Error = TRUE;
                $Mensaje = "El lugar donde se desea estacionar ya está siendo ocupado";
                break;
            }
        }

        //Validar la discapacidad de el estacionamiento y el id de donde va el auto
        if($Error == False){
            $Insertar->bindValue(":p1",$valPatente);
            $Insertar->bindValue(":p2",$valColor);
            $Insertar->bindValue(":p3",$valMarca);
            $Insertar->bindValue(":p4",$valDate);
            $Insertar->bindValue(":p5",$valNumero);
            if($valDiscapacitado==TRUE){
                if($DisponibilidadDiscapasitados==3){
                    $Insertar->bindValue(":p6",FALSE);
                }else{
                    $Insertar->bindValue(":p6",True);
                }
            }
            $Insertar->bindValue(":p7",$valPiso);
            $Insertar->execute();
        }

});


$app->POST('/EgresarAuto', function() use($app) {	
        //Variables del auto
        $valDate = date("Y-m-d H:i:s");
        $valPatente = $app->request->post("Patente");
        $valDateAuto==NULL;

        //
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=Estacionamiento","root","");
        }catch(PDOExeption $e){
            echo '<script language="javascript">alert("Falla en conectar a la DB");</script>'; 
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $Consulta = $pdo->prepare('SELECT * FROM estacionamientos WHERE Patente = :Pat'); 
        $Consulta->bindValue(":Pat",$valPatente);

        if($Consulta->Execute()!=False){
            $Resultado = $Consulta->fetchAll();
            $valDateAuto=$Resultado["Horario"];
        }else{
            echo "No se encontro auto con dicha Patente";
        }

        if($valDateAuto!=NULL){
            $DELETE= $pdo->prepare("DELETE FROM `estacionamientos` WHERE Patente = :Pat ");
            $DELETE->bindValue(":Pat",$valPatente);
            $DELETE->execute();
        }
 });

$app->POST('/Update', function() use($app){	

        //Variables del auto        
        $valPatente = $app->request->post("Patente");
        $valPiso = $app->request->post("Piso");
        $valNumero = $app->request->post("id_cochera");        
        $valDiscapacitado = $app->request->post("Discapacidad");    

        //Abrimos coneccion a la DB
        try{
            $pdo = new PDO("mysql:host=localhost;dbname=Estacionamiento","root","");
        }catch(PDOExeption $e){
            echo '<script language="javascript">alert("Falla en conectar a la DB");</script>'; 
        }
        //Establecemos caracteristicas y consultas a la DB
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $instruccion = "UPDATE estacionamientos SET ";
        $Coma = FALSE;
        
        if($valPiso!=NULL){
            $Coma = true;
            $instruccion .= "Piso=[:P1]";
        }
        if($valNumero!=NULL){
            if($Coma==true){
                $instruccion .=",";
            }
            $instruccion .= "_id=[:P2]";
            $Coma = true;
        }
        if($valNumero!=NULL){
            if($Coma==true){
                $instruccion .=",";
            }
            $instruccion .= "Discapacidad=[:P3]";
        }
        
        $instruccion.=", WHERE Patente = :pat";
        
        $UPDATE = $pdo->prepare($instruccion); 
        $Consulta->bindValue(":Pat",$valPatente);
        $Consulta->bindValue(":P1",$valPiso);
        $Consulta->bindValue(":P2",$valNumero);
        $Consulta->bindValue(":P3",$valDiscapacitado);

        $Consulta->Execute();    

});


//IMPLEMENTAR INSTRUCCIONES GET, POST, PUT, DELETE
//$app->METODO('/RUTEO', CALL_BACK);

$app->run();
?>