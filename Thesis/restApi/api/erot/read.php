<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/erot.php';


    $database = new Database();
    $db = $database->connect();

    $erot = new Erot($db);

    $result = $erot->read();
   

    echo $result;
?>