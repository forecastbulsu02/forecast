<?php
    ob_start();
    session_start();
    $response = array();

    date_default_timezone_set('Asia/Manila');
    $today = date("Y-m-d");
    if($_POST['isNewLoginStudent'] === "true"){
        $user = $_POST['username'];
        $pass = $_POST['password'];
        if($user == "superadmin" && $pass == "superadmin"){
            array_push($response,"SUCCESS");
        }else{
            array_push($response,"INVALID_PASSWORD");
        }
    } else if($_POST['isLogout'] === "true"){
        array_push($response,"SUCCESS");
    }
    ob_end_clean(); 
    echo json_encode($response);
?>