<?php
    
    $target_dir = 'Audio/'; //folder name where your files will be stored. create this folder inside "file_upload_api" folder
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    $response = array('success' => false, 'message' => 'Sorry, there was an error uploading your file.');

    $data = $_POST['sender_information'];
    $json_data = json_decode($data , true);
    $file_type = $json_data['file_type'];

    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        $response = array('success' => true, 'file_type' => 'File type is' . $file_type);
    }
    //$response = array('success' => true, 'message' =>$target_dir);
    
    echo json_encode($response);
?>
