<?php

include('connect.php');
ini_set('display_errors', 1);

if (isset($_POST['user'])){
    $user = $_POST['user'];
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    exit();
}

if (isset($_POST['seen'])){
    $seen = $_POST['seen'];
}

//Getting user ID
$getuser = $mysqli->prepare("SELECT id FROM users WHERE user=?");
$getuser->bind_param('s', $user);
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
$feed = "user_id='$userid'";
$follow_list = $mysqli->prepare("SELECT user_id2 FROM followers WHERE user_id='$userid'");
$follow_list->execute();
$result = $follow_list->get_result();
while($a = $result->fetch_assoc()){
    $id = $a['user_id2'];
    $following[] = $a['user_id2'];
    $feed .= " OR user_id='$id'";
}

if(isset($following)){
    $followExl = "(" . strval($userid);
    foreach ($following as $value){
        $followExl .= ", $value";
    }
    $followExl .= ")";
}

if(!isset($feed)){
    $feed = "user_id";
}
if(!isset($seen)){
    $seen = "id";
}

//Get posts of people you followed
$query = $mysqli->prepare("SELECT SUBQUERY.* from (SELECT * FROM posts WHERE $feed) AS SUBQUERY WHERE id NOT IN $seen");
$query->execute();
$results = $query->get_result();
while($a = $results->fetch_assoc()){
    $response[] = $a;
}

$query = $mysqli->prepare("SELECT * FROM posts WHERE user_id NOT IN $followExl ORDER BY RAND() LIMIT 1;");
$query->execute();
$results = $query->get_result();
while($a = $results->fetch_assoc()){
    $response[] = $a;
}

//Check if any response were found
if(isset($response)){
    echo json_encode($response);
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "posts not found";
    echo json_encode($response);
    exit();
}

?>