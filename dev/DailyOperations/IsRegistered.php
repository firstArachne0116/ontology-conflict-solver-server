<?php 
require_once '../../includes/DataBaseOperations.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if ( isset($_POST["expertId"]) ) {

			$expertId = $_POST["expertId"];

	        $db = new DataBaseOperations();

	        if($db->isExpertRegistered($expertId) == 1){
	       	    $response['message'] = "Null";		
	        } else {
	       	    $response['message'] = "NotNull";	
	        }
	        
	        echo json_encode($response);		                 
		}
	}
?>