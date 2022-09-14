<?php

include('connect.php');

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

if(isset($_POST['pnumber'])){
    $pnumber = $_POST['pnumber'];
}
else{
    $pnumber = NULL;
}


$query = $mysqli->prepare("INSERT INTO `users` (`id`, `user`, `password`, `email`, `phone_number`, `fname`, `lname`) VALUES (NULL, ?, ?, ?, ?, NULL, NULL);");
$query->bind_param("ssss", $user, $pass, $email, $pnumber);
$query->execute();

$response = [];
$response["success"] = true;

echo json_encode($response);

?>