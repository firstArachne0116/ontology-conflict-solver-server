<?php 

require_once '../../includes/DataBaseOperations.php';

$response = array(); 


if($_SERVER['REQUEST_METHOD']=='POST'){

    $choice         = $_POST['choice'];
    $termId         = (int)$_POST['termId'];
    $expertId       = (int)$_POST['expertId'];

    $writtenComment = $_POST['writtenComment'];
    $voiceComment   = $_POST['voiceComment'];

    $db = new DataBaseOperations();

    $resultSubmitDecision = $db->submitDecision($termId, $expertId, $choice, $_POST['writtenComment'], $_POST['voiceComment']);

    if($resultSubmitDecision == 1){

        $response['error'] = false;
        $response['message'] = "Submission Successful";
        $response['sql'] = "Update `CategorySolution` Set choice = '$choice', writtenComment = '$writtenComment', voiceComment = '$voiceComment', isSolved = 1 where termId = $termId and expertId = $expertId";

    } else {

      $response['error'] = true;
      $response['message'] = "Submission Failed";

    }
}
echo json_encode($response);
