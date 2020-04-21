<?php

require_once '../../includes/DataBaseOperations.php';
$definitions = array(); 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $db = new DataBaseOperations();

        $termId = $_GET['termId'];
        $expertId = $_GET['expertId'];
        $db->addDefinition($termId, $expertId, $_GET['definition']);

        $result = $db->getDefinitions($termId, $expertId);
        $data = [];
        //output data of each row
        while($row = $result->fetch_assoc()){
            $id   = $row['id'];
            $definition   = $row['definition'];
            $definitions[] = array("id"=>$id,
                            "definition"=>$definition);
        }
    }
    echo json_encode(array("definition"=>$definitions));
?>
