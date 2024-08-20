<?php
class Conexion{

    function getConexion(){
        //varialbles
        $url="localhost:3307";
        $user="root";
        $pass="";
        $bd="MinimarketExpress";
        $cn=mysqli_connect($url,$user,$pass,$bd);

        return $cn;
    }

    
}

?>