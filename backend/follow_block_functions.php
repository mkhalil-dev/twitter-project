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

//Setting DB depending on the op
if($op == 'follow'){
    $db = 'followers';
}
else if($op == 'unfollow'){
    $db = 'followers';
}
else if($op == 'block'){
    $db = 'blocks';
}
else if($op == 'unblock'){
    $db = 'blocks';
}
else{
    $response = [
        "success" => false,
        "message" => "operation type not found"
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

//Getting user ID, Looping over both username
$userid = [];
for ($x = 0; $x <= 1; $x++) {  
    $getuser = $mysqli->prepare("SELECT id FROM users WHERE user=?");
    $getuser->bind_param('s', $user[$x]);
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

$user1 = $userid[0]['id'];
$user2 = $userid[1]['id'];
    
//VERIFICATION IF ALREADY FOLLOWED / UNFOLLOWED / BLOCKED / UNBLOCKED
$userverf = $mysqli->prepare("SELECT * FROM `$db` WHERE user_id=? AND user_id2=?");
$userverf->bind_param('ss', $user1, $user2);
$userverf->execute();
$result = $userverf->get_result()->fetch_assoc();

//IF ALREADY FOLLOWED / UNFOLLOWED / BLOCKED / UNBLOCKED
if(($result && $op == 'follow') || (!$result && $op == 'unfollow') || ($result && $op == 'block') || (!$result && $op == 'unblock')){
    $response = [
        "success" => true,
        "message" => 'nothing has been done'
    ];
    echo json_encode($response);
    exit();
}

//Setting the follow/block record
if($op == 'follow' || $op == 'block'){
    $query = $mysqli->prepare("INSERT INTO `$db` (`user_id`, `user_id2`) VALUES (?, ?);");
    $query->bind_param("ss", $user1, $user2);
    $query->execute();
    if($op == 'block'){
        $query2 = $mysqli->prepare("DELETE FROM `followers` WHERE user_id='$user1' AND user_id2 ='$user2'");
        $query2->execute();
    }
    $response = [
        "success" => true
    ];
    echo json_encode($response);
}
//Remove follow/block Record
else if($op == 'unfollow' || $op == 'unblock'){
    $query = $mysqli->prepare("DELETE FROM `$db` WHERE user_id=? AND user_id2=?");
    $query->bind_param("ss", $user1, $user2);
    $query->execute();
    $response = [
        "success" => true
    ];
    echo json_encode($response);
}


?>