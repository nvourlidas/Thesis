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

    $erot->title = $data->title;
    $erot->question= $data->question;
    $erot->answers=$data->answers;
    $erot->type= $data->type;
    $erot->date= $data->date;
    $erot->tmima= $data->tmima;
    $erot->idrima= $data->idrima;
    $erot->crby= $data->crby;
  

    if($erot->tmima==4){
      $erot->tmima1="Ηλεκτρολόγων Μηχανικών και Μηχανικών Υπολογιστών";
    }else if($erot->tmima==5){
      $erot->tmima1="Μηχανολόγων Μηχανικών";
    }else if($erot->tmima==6){
      $erot->tmima1="Χημικών Μηχανικών";
    }else if($erot->tmima==9){
      $erot->tmima1="Παιδαγωγικό Νηπιαγωγών";
    }else if($erot->tmima==10){
      $erot->tmima1="Εικαστικών και Εφαρμοσμένων Τεχνών";
    }else if($erot->tmima==11){
      $erot->tmima1="Όλα τα Τμήματα";
    }

    if($erot->idrima==1){
      $erot->idrima1="Γραμματεία Πρύτανη";
    }else if($erot->idrima==2){
      $erot->idrima1="Γραμματεία Συγκλήτου";
    }else if($erot->idrima==3){
      $erot->idrima1="Γραμματεία Ειδικού Λογαριασμού Κονδυλίων Έρευνας";
    }else if($erot->idrima==4){
      $erot->idrima1="Γραφείο Διασύνδεσης";
    }else if($erot->idrima==5){
      $erot->idrima1="Γραφείο Πρακτικής Άσκησης";
    }else if($erot->idrima==6){
      $erot->idrima1="Διεύθυνση Διοίκησης και Οικονομικής Διαχείρισης";
    }else if($erot->idrima==7){
      $erot->idrima1="Δομή Απασχόλησης και Σταδιοδρομίας";
    }else if($erot->idrima==8){
      $erot->idrima1="Μονάδα Διασφάλισης Ποιότητας";
    }else if($erot->idrima==9){
      $erot->idrima1="Τμήμα Ακαδημαϊκών Θεμάτων";
    }else if($erot->idrima==10){
      $erot->idrima1="Τμήμα Διεθνών Σχέσεων και Ευρωπαϊκών Προγραμμάτων";
    }else if($erot->idrima==11){
      $erot->idrima1="Τμήμα Διοίκησης Προσωπικού";
    }else if($erot->idrima==12){
      $erot->idrima1="Τμήμα Μηχανοργάνωσης";
    }else if($erot->idrima==13){
      $erot->idrima1="Τμήμα Οικονομικής Διαχείρισης";
    }else if($erot->idrima==14){
      $erot->idrima1="Τμήμα Τεχνικών Υπηρεσιών";
    }

    

    
    $result = $erot->create();

    echo $result;
        

 

  

    
?>