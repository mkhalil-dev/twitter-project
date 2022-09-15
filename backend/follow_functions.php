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
if(isset($_POST['user']) && isset($_POST['userfollow'])){
    $user = $_POST['user'];
    $userfollow = $_POST['userfollow'];
}
else{
    $response = [
        "success" => false,
        "message" => "missing post elements"
    ];
    echo json_encode($response);
    exit();
}

//follow and unfollow function depending on the type of operation
function follow(){
    
}

function unfollow(){

}


?>