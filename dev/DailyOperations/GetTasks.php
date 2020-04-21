<?php
require_once '../../includes/DataBaseOperations.php';

$response = array(); 
$err = array();
$categoryData   = array();
$approveData = array();
$addTermData = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $expertId = $_POST["expertId"];

        $db = new DataBaseOperations();
        $categoryTasks = $db->getSolvedCategoryTask($expertId);

        while( $task = $categoryTasks->fetch_assoc() ) {
            $termId     = $task['termId'];
            $term       = $task['term'];
            $data       = $task['data'];
            $isSolved   = 1;
            $result     = $db->countSolvedConflicts($termId);
            $count      = $result['COUNT(expertId)'];
            $type       = 'category';

            $categoryData[] = array("termId"=>$termId, "term"=>$term, "type"=>$type, "data"=>$data,"isSolved"=>$isSolved, "count"=>$count);
        }

        $categoryTasks = $db->getUnSolvedCategoryTask($expertId);

        while( $task = $categoryTasks->fetch_assoc() ) {
            $termId     = $task['termId'];
            $term       = $task['term'];
            $data       = $task['data'];
            $isSolved   = 0;
            $result     = $db->countSolvedConflicts($termId);
            $count      = $result['COUNT(expertId)'];
            $type       = 'category';

            $categoryData[] = array("termId"=>$termId, "term"=>$term, "type"=>$type, "data"=>$data,"isSolved"=>$isSolved, "count"=>$count);
        }

        $approveTasks = $db->getApproveTask($expertId);
        
        while( $task = $approveTasks->fetch_assoc() ) {
            $termId     = $task['termId'];
            $term       = $task['term'];
            $data       = $task['data'];
            $isSolved   = $task['isSolved'];
            $count      = $db->countSolvedApproveConflicts($termId);
            // $count      = $result['COUNT(expertId)'];
            $type       = 'synonym';

            $approveData[] = array("termId"=>$termId, "term"=>$term, "type"=>$type, "data"=>$data,"isSolved"=>$isSolved, "count"=>$count, "sCount" => $task['sentenceCount']);
        }

        $addTermTasks = $db->getAddTermTasks($expertId);
        
        while( $task = $addTermTasks->fetch_assoc() ) {
            $termId     = $task['termId'];
            $term       = $task['term'];
            $data       = $task['data'];
            $isSolved   = $task['isSolved'];
            $result     = $db->countSolvedConflicts($termId);
            $count      = $result['COUNT(expertId)'];
            $type       = 'addTerm';

            $addTermData[] = array("termId"=>$termId, "term"=>$term, "type"=>$type, "data"=>$data,"isSolved"=>$isSolved, "count"=>$count);
        }

        $response = array_merge($categoryData, $approveData, $addTermData);

        if( empty($response) ){

            $stat = "Null";

        } else {

            $stat = "NotNull";

        }

    }
echo json_encode(array("task_data"=>$response,"status"=>$stat));
?>
