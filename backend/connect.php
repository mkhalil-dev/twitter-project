<?php

header('Access-Control-Allow-Origin: *');

$server = "localhost";
$user = "root";
$pass = "";
$dbname = "twitterDB";

$mysqli = new mysqli($server, $user, $pass, $dbname);

if($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
};

?>