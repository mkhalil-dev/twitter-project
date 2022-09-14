<?php

include('connect.php');

//Check if body is all received, if not return an error
if(isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
} else {
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    exit();
}

//Checking if username exists and getting the password
$query = $mysqli->prepare("SELECT pass FROM users WHERE user='$user'");
$query->execute();
$results = $query->get_result();
$a = $results->fetch_assoc();

//if user/pass combo matches
if($a['pass'] == $pass ){
    $response = [];
    $response["success"] = true;
    $response["message"] = "login succesfull";
    echo json_encode($response);
}
//if login failed
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "login failed, user or password combination is not correct";
    echo json_encode($response);
}

?>