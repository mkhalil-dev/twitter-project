<?php

include('connect.php');

//GET OPERATION
if(isset($_POST['op'])){
    $op = $_POST['op'];
}
else{
    $response = [
        "success" => false,
        "message" => "operation not defined"
    ];
    echo json_encode($response);
    exit();
}

//Check if both user1 and user 2 are set in Post
if(isset($_POST['user1']) && isset($_POST['user2'])){
    $user = [];
    $user[0] = $_POST['user1'];
    $user[1] = $_POST['user2'];
}
else{
    $response = [
        "success" => false,
        "message" => "missing post elements"
    ];
    echo json_encode($response);
    exit();
}

//Getting user ID Looping over both username
$userid = [];
for ($x = 0; $x <= 1; $x++) {  
    $getuser = $mysqli->prepare("SELECT id FROM users WHERE user='$user[$x]'");
    $getuser->execute();
    $userid[$x] = $getuser->get_result()->fetch_assoc();
}

//Checking if both user exists
if(!$userid[0] || !$userid[1]){
    $response = [
        "success" => false,
        "message" => "user not found"
    ];
    echo json_encode($response);
    exit();
}
    
//follow and unfollow function depending on the type of operation
if($op == 'follow'){
    $query = $mysqli->prepare("INSERT INTO `followers` (`user_id`, `followed`) VALUES (?, ?);");
    $query->bind_param("ss", $userid[0]['id'], $userid[1]['id']);
    $query->execute();
    $response = [
        "success" => true
    ];
    echo json_encode($response);
    //SET VERIFICATION IF ALREADY FOLLOWED
}

?>