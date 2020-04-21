<?php 

require_once '../../includes/DataBaseOperations.php';

$response = array(); 

if($_SERVER['REQUEST_METHOD']=='POST'){

	if(isset($_POST['username']) and isset($_POST['password'])){

		$db = new DataBaseOperations(); 

		if($db->expertLogin($_POST['username'], $_POST['password'])){

			$user = $db->getExpertByUsername($_POST['username']);

			$response['error']    = false; 
			$response['expertId'] = $user['expertId'];
			$response['email']    = $user['email'];
			$response['username'] = $user['username'];
		} else {

			$response['error']   = true; 
			$response['message'] = "Invalid username or password";		
		}
	} else {

		$response['error']   = true; 
		$response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);