<?php 	
    require_once '../../includes/DataBaseOperations.php';

    $db = new DataBaseOperations();

    $result = $db->getAllTokens();

	$tokens = array();

	if(mysqli_num_rows($result) > 0 ){
		while ($row = $result->fetch_assoc()) {
			$tokens[] = $row["token"];
		}
	}
	$message = array("message" => " Conflict Solver has an update");
	$message_status = $db->sendNotification($tokens, $message);
	echo $message_status;
 ?>
