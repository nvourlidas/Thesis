<?php
class Erot {
    
    private $conn;
    private $table = 'erot';
    private $table2 = 'questions';
    private $table3 = 'answers';
    
    
    public $erotid;
    public $title;
    public $erot_id;
    public $question;
    public $quesid;
    public $answers;
    public $answer;
    public $question_id;
    public $type;
    public $ansid;
    public $date;
    public $tmima;
    public $tmima1;
    public $apost;
    public $apantiseis;
    public $uid;
    public $idrima;
    public $idrima1;
    public $crby;
    public $text;
    


    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        
        $erid=array();
        $tit=array();

        $query="SELECT * FROM $this->table ORDER BY erotid ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch()){
            $id=$row['erotid'];
            $query2="SELECT * FROM $this->table2 WHERE erot_id=$id ORDER BY quesid ASC ";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->execute();

            $questions = array();
            while($row2 = $stmt2->fetch()) {
                

                $id1=$row2['quesid'];
                $query3="SELECT * FROM $this->table3 WHERE question_id=$id1 ORDER BY ansid ASC ";
                $stmt3 = $this->conn->prepare($query3);
                $stmt3->execute();

                $ans=array();
                while ($row3 = $stmt3->fetch()) {
                    $ans[]=array('answer' => $row3['answer'],  'ansid' => $row3['ansid']);
                }

                $questions[]=array_merge(array('question' => $row2['question'], 'quesid' => $row2['quesid'],'type' => $row2['atype']), array('answers' => $ans));

            }
            $users = array();
            $query4="SELECT * FROM apantiseis WHERE erot_id=$id  ";
                $stmt4 = $this->conn->prepare($query4);
                $stmt4->execute();

                while($row4 = $stmt4->fetch()){
                    $users[]=array('user'=> $row4['useid']);
                }

                if($row['expire'] > date("Y-m-d")){
                    $energ= 1;
                }else{
                    $energ =2;
                }
            $erot_item=array_merge(array('users'=>$users),array('erotid'=> $row['erotid'], 'title'=>$row['title'], 'date'=>$row['expire'], 'energ' => $energ, 'tmima'=>$row['tmima'], 'tmima1'=>$row['tmima1'], 'apost'=>$row['apost'], 'idrima'=>$row['idrima'], 'idrima1'=>$row['idrima1'], 'crby'=>$row['crby']));

            $data[]=array_merge($erot_item, array('questions' => $questions));
            
        }

        

        return json_encode($data);
       

    }

    
    

    public function read_single() {
        $query= "SELECT * FROM erot WHERE erotid = ?" ;

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->erotid);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row['title'];
    }

    public function create() {
        $apos=1;
        $query="INSERT INTO $this->table (title,expire,tmima,tmima1,apost,idrima,idrima1,crby) VALUES (:title, :date, :tmima, :tmima1, :apost, :idrima, :idrima1, :crby)";
        $stmt = $this->conn->prepare($query);
        $this->title = htmlspecialchars(strip_tags($this->title));
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':date',$this->date);
        $stmt->bindParam(':tmima',$this->tmima);
        $stmt->bindParam(':tmima1',$this->tmima1);
        $stmt->bindParam(':apost',$apos);
        $stmt->bindParam(':idrima',$this->idrima);
        $stmt->bindParam(':idrima1',$this->idrima1);
        $stmt->bindParam(':crby',$this->crby);
        $stmt->execute();

        $this->erot_id= $this->conn->lastInsertId();

        $query2="INSERT INTO $this->table2 (question, erot_id, atype) VALUES (:question, :erot_id, :atype)";
        $stmt2 = $this->conn->prepare($query2);
        $this->question = htmlspecialchars(strip_tags($this->question));
        $this->erot_id = htmlspecialchars(strip_tags($this->erot_id));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $stmt2->bindParam(':question', $this->question);
        $stmt2->bindParam(':erot_id', $this->erot_id);
        $stmt2->bindParam(':atype', $this->type);


        $stmt2->execute();


        $this->question_id= $this->conn->lastInsertId();

        if($this->type == 1){
            $answ = 'textarea';
            $query3="INSERT INTO $this->table3 (answer, question_id) VALUES (:answer, :question_id)";
        $stmt3 = $this->conn->prepare($query3);
        $this->answers[$i] = htmlspecialchars(strip_tags($this->answers[$i]));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $stmt3->bindParam(':answer', $answ );
        $stmt3->bindParam(':question_id', $this->question_id);
        


        $stmt3->execute();
        }else{

        for($i=0; $i<count($this->answers); $i++){
        $query3="INSERT INTO $this->table3 (answer, question_id) VALUES (:answer, :question_id)";
        $stmt3 = $this->conn->prepare($query3);
        $this->answers[$i] = htmlspecialchars(strip_tags($this->answers[$i]));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $stmt3->bindParam(':answer', $this->answers[$i]);
        $stmt3->bindParam(':question_id', $this->question_id);
        


        $stmt3->execute();
            
        }
    }

        $id=$this->erot_id;
        $title=$this->title;
            $query4="SELECT * FROM $this->table2 WHERE erot_id=$id ORDER BY quesid ASC ";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->execute();

            $questions = array();
            while($row2 = $stmt4->fetch()) {
                

                $id1=$row2['quesid'];
                $query5="SELECT * FROM $this->table3 WHERE question_id=$id1 ORDER BY ansid DESC ";
                $stmt5 = $this->conn->prepare($query5);
                $stmt5->execute();

                $ans=array();
                while ($row3 = $stmt5->fetch()) {
                    $ans[]=array('answer' => $row3['answer'], 'ansid' => $row3['ansid']);
                }

                $questions[]=array_merge(array('question' => $row2['question'], 'quesid' => $row2['quesid'], 'type' => $row2['atype']), array('answers' => $ans));

            }

            $erot_item=array('erotid'=> $id, 'title'=>$title, 'date'=>$this->date, 'tmima'=>$this->tmima, 'tmima1'=>$this->tmima1, 'apost'=>$apos, 'idrima'=>$this->idrima,'idrima1'=>$this->idrima1, 'crby'=>$row['crby'] );

            $data=array_merge($erot_item, array('questions' => $questions));


            return json_encode($data);

      
    }


    public function update() {
        $query="UPDATE $this->table SET title = :title  WHERE erotid = :id";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->erotid = htmlspecialchars(strip_tags($this->erotid));

        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':id', $this->erotid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function delete() {
        $query="DELETE FROM $this->table  WHERE erotid = :id";

        $stmt = $this->conn->prepare($query);

        $this->erotid = htmlspecialchars(strip_tags($this->erotid));

        $stmt->bindParam(':id', $this->erotid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function qcreate() {
        $query2="INSERT INTO $this->table2 (question, erot_id, atype) VALUES (:question, :erot_id, :atype)";
        $stmt2 = $this->conn->prepare($query2);
        $this->question = htmlspecialchars(strip_tags($this->question));
        $this->erot_id = htmlspecialchars(strip_tags($this->erot_id));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $stmt2->bindParam(':question', $this->question);
        $stmt2->bindParam(':erot_id', $this->erot_id);
        $stmt2->bindParam(':atype', $this->type);

        $stmt2->execute();

        $this->question_id= $this->conn->lastInsertId();

        $ans=array();
        if($this->type == 1){
            $answ = 'textarea';
            $query3="INSERT INTO $this->table3 (answer, question_id) VALUES (:answer, :question_id)";
        $stmt3 = $this->conn->prepare($query3);
        $this->answers[$i] = htmlspecialchars(strip_tags($this->answers[$i]));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $stmt3->bindParam(':answer', $answ );
        $stmt3->bindParam(':question_id', $this->question_id);
        


        $stmt3->execute();
        }else{
            for($i=0; $i<count($this->answers); $i++){
            $query3="INSERT INTO $this->table3 (answer, question_id) VALUES (:answer, :question_id)";
            $stmt3 = $this->conn->prepare($query3);
            $this->answers[$i] = htmlspecialchars(strip_tags($this->answers[$i]));
            $this->question_id = htmlspecialchars(strip_tags($this->question_id));
            $stmt3->bindParam(':answer', $this->answers[$i]);
            $stmt3->bindParam(':question_id', $this->question_id);
            
            $stmt3->execute();

            $ans[$i]=array('answer' => $this->answers[$i]);
            }
        }
        $data[]=array_merge(array('question' => $this->question),array('answers' => $ans));

        return json_encode(array_merge(array('question' => $this->question),array('answers' => $ans)));
    }

    public function acreate(){
        $query2="INSERT INTO $this->table3 (answer, question_id) VALUES (:answer, :question_id)";
        $stmt2 = $this->conn->prepare($query2);
        $this->answer = htmlspecialchars(strip_tags($this->answer));
        $this->question_id = htmlspecialchars(strip_tags($this->question_id));
        $stmt2->bindParam(':answer', $this->answer);
        $stmt2->bindParam(':question_id', $this->question_id);

        $stmt2->execute();

        $data=array('answer'=>$this->answer);

        return json_encode($data);
    }

    public function qdelete() {
        $query="DELETE FROM $this->table2  WHERE quesid = :quesid";

        $stmt = $this->conn->prepare($query);

        $this->quesid = htmlspecialchars(strip_tags($this->quesid));

        $stmt->bindParam(':quesid', $this->quesid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function adelete() {
        $query="DELETE FROM $this->table3  WHERE ansid = :ansid";

        $stmt = $this->conn->prepare($query);

        $this->ansid = htmlspecialchars(strip_tags($this->ansid));

        $stmt->bindParam(':ansid', $this->ansid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function qupdate() {
        $query="UPDATE $this->table2 SET question = :question  WHERE quesid = :id";

        $stmt = $this->conn->prepare($query);

        $this->question = htmlspecialchars(strip_tags($this->question));
        $this->quesid = htmlspecialchars(strip_tags($this->quesid));

        $stmt->bindParam(':question', $this->question);
        $stmt->bindParam(':id', $this->quesid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    public function aupdate() {
        $query="UPDATE $this->table3 SET answer = :answer  WHERE ansid = :id";

        $stmt = $this->conn->prepare($query);

        $this->answer = htmlspecialchars(strip_tags($this->answer));
        $this->ansid = htmlspecialchars(strip_tags($this->ansid));

        $stmt->bindParam(':answer', $this->answer);
        $stmt->bindParam(':id', $this->ansid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function apantisi(){
        $erotisi=array();
        for($i=0; $i<count($this->apantiseis); $i++){
            $query="SELECT question_id FROM $this->table3 WHERE ansid= :apid";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':apid', $this->apantiseis[$i]);
            $stmt->execute();

           while( $row=$stmt->fetch()){
               $erotisi[$i]=$row['question_id'];
           }
        }

       
        foreach($erotisi as $x){
            $query2="SELECT erot_id FROM $this->table2 WHERE quesid= $x";
            $stmt2 = $this->conn->prepare($query2);
           
            $stmt2->execute();

            while( $row=$stmt2->fetch()){
                $pin=$row['erot_id'];
            }
            
        }

        $query3="INSERT INTO apantiseis (useid,erot_id,texta) VALUES (:usid, :eid, :texta)";
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->bindParam(':usid', $this->uid);
        $stmt3->bindParam(':eid',$pin);
        $stmt3->bindParam(':texta',$this->text);
        $stmt3->execute();

        $ap_id= $this->conn->lastInsertId();
        for($i=0; $i<count($erotisi); $i++){
        $query4="INSERT INTO erotiseis (ques_id,ans_id,ap_id) VALUES (:qid, :aid, :pid)";
        $stmt4 = $this->conn->prepare($query4);
        $stmt4->bindParam(':qid', $erotisi[$i]);
        $stmt4->bindParam(':aid',$this->apantiseis[$i]);
        $stmt4->bindParam(':pid',$ap_id);
        $stmt4->execute();
        }

        
        $query5="SELECT * FROM apantiseis WHERE apid=$ap_id";
            $stmt5 = $this->conn->prepare($query5);
            $stmt5->execute();

            
            while($row5 = $stmt5->fetch()){
                $data=array(
                    'user'=> $row5['useid'],
                );
            }

            return json_encode($data);
        
    }

    public function readA(){
        
        $erid=array();
        $tit=array();

        $query="SELECT * FROM $this->table ORDER BY erotid ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        while($row = $stmt->fetch()){
            $id=$row['erotid'];
            $query2="SELECT * FROM $this->table2 WHERE erot_id=$id ORDER BY quesid ASC ";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->execute();

            $sum2=0;
                    
                $query7="SELECT * FROM apantiseis WHERE erot_id=$id";
                $stmt7=$this->conn->prepare($query7);
                $stmt7->execute();

                    
                $texta=array();
                $k=0;
                while($row7 = $stmt7->fetch()){
                    $sum2=$sum2+1;
                    if($row7['texta'] != null){
                    $texta[$k]=array('text' =>$row7['texta']);
                    $k=$k+1;
                    }
                }

            $questions = array();
            while($row2 = $stmt2->fetch()) {
                

                $id1=$row2['quesid'];
                $query3="SELECT * FROM $this->table3 WHERE question_id=$id1 ORDER BY ansid ASC ";
                $stmt3 = $this->conn->prepare($query3);
                $stmt3->execute();

                $sum1=0;
                    
                $query6="SELECT * FROM erotiseis WHERE ques_id=$id1";
                $stmt6=$this->conn->prepare($query6);
                $stmt6->execute();

                    
                    
                while($row6 = $stmt6->fetch()){
                    $sum1=$sum1+1;
                }

                $ans=array();
                while ($row3 = $stmt3->fetch()) {
                    $sum=0;
                    $id2=$row3['ansid'];
                    $query5="SELECT * FROM erotiseis WHERE ans_id=$id2";
                    $stmt5=$this->conn->prepare($query5);
                    $stmt5->execute();

                    
                    
                    while($row5 = $stmt5->fetch()){
                        $sum=$sum+1;
                    }

                    if($sum1!=0){
                        $mo=100*$sum/$sum1;
                    }else{
                        $mo=0;
                    }

                    $ans[]=array_merge(array('answer' => $row3['answer'],  'ansid' => $row3['ansid'], 'apant'=> $mo, 'kath'=>$sum),array('texta'=>$texta));
                }

                $questions[]=array_merge(array('question' => $row2['question'], 'quesid' => $row2['quesid'], 'apant1'=>$sum1, 'type' => $row2['atype']),  array('answers' => $ans));

            }
            $users = array();
            $query4="SELECT * FROM apantiseis WHERE erot_id=$id  ";
                $stmt4 = $this->conn->prepare($query4);
                $stmt4->execute();

                while($row4 = $stmt4->fetch()){
                    $users[]=array('user'=> $row4['useid']);
                }

            $erot_item=array_merge(array('users'=>$users),array('erotid'=> $row['erotid'], 'title'=>$row['title'], 'date'=>$row['expire'], 'tmima'=>$row['tmima'], 'tmima1'=>$row['tmima1'], 'apost'=>$row['apost'], 'apant2'=>$sum2, 'idrima'=>$row['idrima'], 'idrima1'=>$row['idrima1']));

            $data[]=array_merge($erot_item, array('questions' => $questions));
            
        }

        

        return json_encode($data);
       

        }

        public function apost(){
            $query="UPDATE $this->table SET apost = :apost  WHERE erotid = :id";

        $stmt = $this->conn->prepare($query);

        $this->apost = htmlspecialchars(strip_tags($this->apost));
        $this->erotid = htmlspecialchars(strip_tags($this->erotid));

        $stmt->bindParam(':apost', $this->apost);
        $stmt->bindParam(':id', $this->erotid);

        if($stmt->execute()) {
            return true;
      }


      printf("Error: %s.\n", $stmt->error);

      return false;
        }
        
    }

    

?>