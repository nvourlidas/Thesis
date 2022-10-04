<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
 
    include_once '../../config/Database.php';
    include_once '../../models/erot.php';
 
 
    $database = new Database();
    $db = $database->connect();
 
    $erot = new Erot($db);

    $erot->erotid = isset($_GET['erotid']) ? $_GET['erotid'] : die();

    $erot->read_single();

    $erot_arr = array(
        'erotid' => $erot->erotid,
        'title' => $erot->title
    );

    print_r(json_encode($erot_arr));
?>