<?php

include('connect.php');




$followers = "user_id='23'";
$followers .= " OR user_id='22'";
$query = $mysqli->prepare("SELECT * FROM posts WHERE $followers ORDER BY created_at DESC");
$query->execute();
$results = $query->get_result();
while($a = $results->fetch_assoc()){
    $response[] = $a;
}
echo json_encode($response);

?>