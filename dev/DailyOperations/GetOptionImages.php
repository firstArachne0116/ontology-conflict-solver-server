<?php

require_once '../../includes/DataBaseOperations.php';
$response = array(); 

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        
        $db = new DataBaseOperations();

        $result = $db->getOptionImages($_GET['ID']);
        //$result = $db->getOptionImages(3);

        $result = mysqli_fetch_array($result);

        $data = array();

        $data["photo"] = $result["photo"];


        $response["success"] = 1;
        $response["image"] = array();

        
        array_push($response["image"], $data);
 
            
        echo json_encode($response);    
    }
?>
