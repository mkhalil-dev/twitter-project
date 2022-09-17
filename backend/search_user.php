<?php

include('connect.php');

if(isset($_GET["search"])){
    $search = $_GET["search"];
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing elements";
    echo json_encode($response);
    exit();
}

$query = $mysqli->prepare('SELECT user FROM users WHERE user like "%'.$search.'%" OR fname like "%'.$search.'%" OR lname like "%'.$search.'%"');
$query->execute();
$result = $query->get_result();

while($a = $result->fetch_assoc()){
    $response[] = $a;
}

echo json_encode($response);

?>