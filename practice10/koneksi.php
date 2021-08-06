<?php

    // buat di local
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_practice9";

    // buat di server
    // $servername = "localhost";
    // $username = "kelasmmx_18102180";
    // $password = "Nn3,2.Wfrd]p";
    // $dbname = "kelasmmx_18102180";

    // Create Connection
    $conn = new mysqli($servername,$username,$password,$dbname);

    // Check Connection
    if($conn->connect_error){
        die("Connection failed : ". $conn->connect_error);
    }
?>