<?php

include('connect.php');

//GET OPERATION
if(isset($_GET['op'])){
    $op = $_GET['op'];
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
    $response = [];
    $response["success"] = false;
    $response["message"] = "user not found";
    echo json_encode($response);
    exit();
}
    
echo json_encode($userid);

//follow and unfollow function depending on the type of operation
/*
function follow(){
    
}

function unfollow(){
    
}
*/

?>