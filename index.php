<?php
    session_start();
    if(isset($_SESSION["USR"])){
        header('Location: Inicio.html');
    }else{
        header('Location: ./PHP/Usuario.php');
    }
?>