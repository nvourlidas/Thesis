<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/erot.php';

    

    $database = new Database();
    $db = $database->connect();

    $erot = new Erot($db);


    $data = json_decode(file_get_contents("php://input"));

    $erot->question_id = $data->question_id;
    
    $erot->answer= $data->answer;
    

   

    
  $result = $erot->acreate();

  echo $result;
  

 

  

    
?>