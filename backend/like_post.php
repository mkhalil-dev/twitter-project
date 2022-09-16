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

//checking op type
if($op != 'like' && $op != 'unlike'){
    $response = [
        "success" => false,
        "message" => "operation type not found"
    ];
    echo json_encode($response);
    exit();
}

//Check if both user and target post are set in Post
if(isset($_POST['user']) && isset($_POST['post'])){
    $user = $_POST['user'];
    $post = $_POST['post'];
}
else{
    $response = [
        "success" => false,
        "message" => "missing post elements"
    ];
    echo json_encode($response);
    exit();
}

//Getting user ID
$getuser = $mysqli->prepare("SELECT id FROM users WHERE user='$user'");
$getuser->execute();
$userid = $getuser->get_result()->fetch_assoc()['id'];

//Validating post ID
$getuser = $mysqli->prepare("SELECT id FROM posts WHERE id='$post'");
$getuser->execute();
$postid = $getuser->get_result()->fetch_assoc();

//Checking if user and post exists
if(!$userid || !$postid){
    $response = [
        "success" => false,
        "message" => "user not found"
    ];
    echo json_encode($response);
    exit();
}
    
//VERIFICATION IF ALREADY LIKED / UNLIKED 
$userverf = $mysqli->prepare("SELECT * FROM `likes` WHERE user_id='$userid' AND post_id='$post';");
$userverf->execute();
$result = $userverf->get_result()->fetch_assoc();

//IF ALREADY Liked / Unliked
if(($result && $op == 'like') || (!$result && $op == 'unlike')){
    $response = [
        "success" => true,
        "message" => 'nothing has been done'
    ];
    echo json_encode($response);
    exit();  
}

//Setting the like record
if($op == 'like'){
    $query = $mysqli->prepare("INSERT INTO `likes` (`user_id`, `post_id`) VALUES (?, ?);");
    $query->bind_param("ss", $userid, $post);
    $query->execute();
    $response = [
        "success" => true
    ];
    echo json_encode($response);
}
//Remove liked Record
else if($op == 'unlike'){
    $query = $mysqli->prepare("DELETE FROM `likes` WHERE user_id='$userid' AND post_id ='$post'");
    $query->execute();
    $response = [
        "success" => true
    ];
    echo json_encode($response);
}

?>