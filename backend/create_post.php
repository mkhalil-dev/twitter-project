<?php

include('connect.php');

if((isset($_POST['content']) || isset($_POST['media_url'])) && isset($_POST['user'])){
    $user = $_POST['user'];
    if(isset($_POST['content'])){
        $content = $_POST['content'];
    }
    else{
        $content = NULL;
    }
    if(isset($_POST['media_url'])){
        $media = $_POST['media_url'];
    }
    else{
        $media = NULL;
    }
}

//Response if both content and media are missing or if user is missing and exit
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    exit();
}

//Getting user ID
$getuser = $mysqli->prepare("SELECT id FROM users WHERE user=?");
$getuser->bind_param('s', $user);
$getuser->execute();
$userid = $getuser->get_result()->fetch_assoc();

//Checking if user exists
if(!$userid){
    $response = [];
    $response["success"] = false;
    $response["message"] = "user not found";
    echo json_encode($response);
    exit();
}

//Creating the post
ini_set('display_errors', 1);
$query = $mysqli->prepare("INSERT INTO `posts` (`id`, `content`, `media_url`, `created_at`, `user_id`) VALUES (NULL, ?, ?, NULL, ?);");
$query->bind_param("sss", $content, $media, $userid['id']);
$query->execute();

//Returning a response
$response = [];
$response["success"] = true;
$response["message"] = "post created succesfully";

echo json_encode($response);

?>