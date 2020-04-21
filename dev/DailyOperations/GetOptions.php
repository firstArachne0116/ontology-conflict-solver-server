<?php

require_once '../../includes/DataBaseOperations.php';
$response = array(); 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        $db = new DataBaseOperations();
        $result = $db->getOptions($_GET['ID']);
		    
        //output data of each row
        while($row = $result->fetch_assoc()){
            $term         = $row['term'];
            $option_      = $row['option_'];
            $definition   = $row['definition'];
            $image_link   = $row['image_link'];
            $data[] = array("option_"=>$option_, 
                            "definition"=>$definition,
                            "image_link"=>$image_link);
        }
        $response = $data;
    }
    echo json_encode(array("options_data"=>$response));
?>
