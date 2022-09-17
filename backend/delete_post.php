<?php

include('connect.php');

//Check if user and postid are set in form data
if (isset($_POST['user']) && isset($_POST['postid'])){
    $user = $_POST['user'];
    $post = $_POST['postid'];
}

//Response if post or user is missing and exit
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    exit();
}

//Get the user id
$getuser = $mysqli->prepare("SELECT id FROM users WHERE user=?");
$getuser->bind_param('s', $user);
$getuser->execute();
$userid = $getuser->get_result()->fetch_assoc()['id'];

//Validating post ID
$getpost = $mysqli->prepare("SELECT id FROM posts WHERE id='$post' AND user_id='$userid'");
$getpost->bind_param('ss', $post, $userid);
$getpost->execute();
$postid = $getpost->get_result()->fetch_assoc()['id'];

//Checking if user and post exists
if(!$userid || !$postid){
    $response = [
        "success" => false,
        "message" => "user or post not found"
    ];
    echo json_encode($response);
    exit();
}

//Delete the requested post
$query = $mysqli->prepare("DELETE FROM `posts` WHERE id=? AND user_id=?");
$query->bind_param('ss', $post, $userid);
$query->execute();
$response = [
    "success" => true
];
echo json_encode($response);

?>