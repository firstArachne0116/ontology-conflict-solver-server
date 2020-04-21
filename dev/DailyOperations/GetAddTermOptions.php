<?php

require_once '../../includes/DataBaseOperations.php';
$sentences = array(); 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        $db = new DataBaseOperations();

        $result = $db->getSentences($_GET['termId']);
        $data = [];
        //output data of each row
        while($row = $result->fetch_assoc()){
            $id   = $row['id'];
            $sentence   = $row['sentence'];
            $sentences[] = array("id"=>$id,
                            "sentence"=>$sentence);
        }

    }
    echo json_encode(array("sentence"=>$sentences));
?>
