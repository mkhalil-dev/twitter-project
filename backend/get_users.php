<?php

include('connect.php');

$query = $mysqli->prepare("SELECT * FROM users");
$query->execute();
$results = $query->get_result();

while($a = $results->fetch_assoc()){
    $response[] = $a;
}

echo json_encode($response);

?>