<?php

require_once '../../includes/DataBaseOperations.php';
$sentences = array(); 
$definitions = array(); 
$approveData = array();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $db = new DataBaseOperations();

        $db->setApproveData($_GET['expertId'], $_GET['sentenceIds'], $_GET['definitionIds']);

    }
?>
