<?php
require_once '../../includes/DataBaseOperations.php';

    $response = array();

	if($_SERVER['REQUEST_METHOD'] == 'POST'){


		if( isset($_POST['username']) and isset($_POST['password']) and isset($_POST['firstname'])  and isset($_POST['lastname']) and isset($_POST['email']) ){
           // operate the data furter
	       $db = new DataBaseOperations();

		   $result = $db->createExpert($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);

	       if($result == 1 ){

               $expertId = $db->setTasksToExpert();
	           $response['error'] = false;
			   $response['message'] = "The user was registered succesfully!";
			   $response['expertId'] = $expertId;

	       } else if($result == 0){

               $response['error'] = true; 
			   $response['message'] = "The username or email are already in use, please choose a different email or username";	
	       } else if($result == 2 ) {

	       	   $response['error'] = true;
               $response['message'] = "An error has occurred, please try again!";

	       }
               
		} else {

            $response['error'] = true;
            $response['message'] = "The required fields are missing";
	    }
	       

	} else {
		$response['error'] = true;
        $response['message'] = "Invalid Request";
	}

	echo json_encode($response);

?>	