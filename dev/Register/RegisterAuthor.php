<?php
require_once '../../includes/DataBaseOperations.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if($_POST['password'] == $_POST['confirmpassword']){
    	    // operate the data further
	        $db = new DataBaseOperations();

	        $result = $db->createAuthor($_POST['username'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);

	        if($result == 1 ){
	             
                $_SESSION['message'] = "Registration successful!";

                //redirect the user to welcome.php
                header("location: AuthorWelcome.php");

	        } else if($result == 2 ) {
	       	        
                $_SESSION['message'] = "An error has occurred, please try again!";
  
            } else if($result == 0){
                                      
		        $_SESSION['message'] = "The username or email are already in use, please choose a different email or username";	
	        }
	    } else {

            $_SESSION['message'] = "Two passwords do not match!";
        }          	    
	} else {	

       $_SESSION['message'] = "Invalid Request";
    }
?>	