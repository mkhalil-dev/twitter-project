<?php

include('connect.php');

//Check if body is all sent, if not return an error
if(isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['email'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
} else {
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing post elements";
    echo json_encode($response);
    exit();
}

//Check if user has set a number, if not continue normally with NULL as value
if(isset($_POST['pnumber'])){
    $pnumber = $_POST['pnumber'];
}
else{
    $pnumber = NULL;
}

//Checking if username or email exists in the backend
$query = $mysqli->prepare("SELECT user FROM users WHERE user='$user' OR email='$email'");
$query->execute();
$results = $query->get_result();

while($a = $results->fetch_assoc()){
    $reply[] = $a;
}

//If user or email exists, exit the script and return an error
if($reply){
    $response = [];
    $response["success"] = false;
    $response["message"] = "User or email already exists!";
    echo json_encode($response);
    exit();
}

//Inserting new user
$query = $mysqli->prepare("INSERT INTO `users` (`id`, `user`, `pass`, `email`, `phone_number`, `fname`, `lname`) VALUES (NULL, ?, ?, ?, ?, NULL, NULL);");
$query->bind_param("ssss", $user, $pass, $email, $pnumber);
$query->execute();

$response = [];
$response["success"] = true;

echo json_encode($response);

?>