<?php 
require_once '../../includes/DataBaseOperations.php';

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		if ( isset($_POST["expertId"]) ) {

			$expertId = $_POST["expertId"];
	        $db = new DataBaseOperations();

	        $result = $db->countUnsolvedConflictsByExpert($expertId);
            
            $count = $result['COUNT(termId)'];
            $unsolvedData = array("count"=>$count);

	        echo json_encode($unsolvedData);		                 
		}
	}
?>