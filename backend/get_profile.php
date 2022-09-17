<?php

include('connect.php');
if(isset($_POST['user'])){
    $user = $_POST['user'];
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing elements";
    echo json_encode($response);
    exit();
}

$query = $mysqli->prepare('SELECT * FROM users WHERE user = "$user"');
$query->execute();
$result = $query->get_result()->fetch_assoc();

echo json_encode($result);

?>