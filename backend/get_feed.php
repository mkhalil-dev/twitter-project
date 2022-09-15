<?php

include('connect.php');

if (isset($_POST['user'])){
    $user = $_POST['user'];
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    //exit();
}

//Getting user ID
$getuser = $mysqli->prepare("SELECT id FROM users WHERE user='$user'");
$getuser->execute();
$userid = $getuser->get_result()->fetch_assoc()['id'];

//Checking if user exists
if(!$userid){
    $response = [];
    $response["success"] = false;
    $response["message"] = "user not found";
    echo json_encode($response);
    exit();
}

//Getting follower list
$follow_list = $mysqli->prepare("SELECT followed FROM followers WHERE user_id='$userid'");
$follow_list->execute();
$result = $follow_list->get_result();
while($a = $result->fetch_assoc()){
    $id = $a['followed'];
    if(!$followed){
        $followed = "user_id='$id'";
    }
    else{
        $followed .= " OR user_id='$id'";
    }
}

if(!$followed){
    $followed = "user_id!='$userid'";
}

//Get posts of people you followed
$query = $mysqli->prepare("SELECT * FROM posts WHERE $followed ORDER BY created_at DESC");
$query->execute();
$results = $query->get_result();
while($a = $results->fetch_assoc()){
    $response[] = $a;
}
echo json_encode($response);

?>