<?php

include('connect.php');
if(isset($_GET['user'])){
    $user = $_GET['user'];
}
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing elements";
    echo json_encode($response);
    exit();
}

$query = $mysqli->prepare("SELECT * FROM (SELECT QUERY.*, COUNT(user_id2) AS followers FROM(SELECT * FROM users U, followers F WHERE U.user = ? AND (F.user_id2 =U.id)) AS QUERY WHERE user_id2 = QUERY.id) AS QUERY1 , (SELECT COUNT(user_id) AS following FROM(SELECT * FROM users U, followers F WHERE U.user = ? AND F.user_id = U.id) AS QUERY WHERE user_id = QUERY.id) as QUERY2");
$query->bind_param('ss', $user, $user);
$query->execute();
$result = $query->get_result()->fetch_assoc();

echo json_encode($result);

?>