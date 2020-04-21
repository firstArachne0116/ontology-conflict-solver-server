<?php 
require_once '../../includes/DataBaseOperations.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if ( isset($_POST["token"]) AND isset($_POST["expertId"]) ) {

			$expertId = $_POST["expertId"];
			$token = $_POST["token"];

	        $db = new DataBaseOperations();

	        if($db->registerToken($expertId,$token) == 1){

	        	$response['error'] = false;
	       	    $response['message'] = "Registration Successful";		

	        } else {

	        	$response['error'] = true;
	       	    $response['message'] = "Registration Failed";	

	        }
	        echo json_encode($response);		                 
		}
	}
?>