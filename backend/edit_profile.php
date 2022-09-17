<?php

include('connect.php');
ini_set('display_errors', 1);

//Check if username is sent, if not then exit
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

//Check if required edits are sent
if(isset($_POST['pnumber']) || isset($_POST['fname']) || isset($_POST['lname']) || isset($_POST['bday']) || isset($_POST['country'])){
    if(isset($_POST['pnumber'])){
        $pnumber = $_POST['pnumber'];
        $query = $mysqli->prepare("UPDATE users SET phone_number=? WHERE user=?");
        $query->bind_param("ss", $pnumber, $user);
        $query->execute();
    }
    else{
        $pnumber = NULL;
    }
    if(isset($_POST['fname'])){
        $fname = $_POST['fname'];
        $query = $mysqli->prepare("UPDATE users SET fname=? WHERE user=?");
        $query->bind_param("ss", $fname, $user);
        $query->execute();
    }
    else{
        $fname = NULL;
    }
    if(isset($_POST['lname'])){
        $lname = $_POST['lname'];
        $query = $mysqli->prepare("UPDATE users SET lname=? WHERE user=?");
        $query->bind_param("ss", $lname, $user);
        $query->execute();
    }
    else{
        $lname = NULL;
    }
    if(isset($_POST['bday'])){
        $bday = $_POST['bday'];
        $query = $mysqli->prepare("UPDATE users SET bday=? WHERE user=?");
        $query->bind_param("ss", $bday, $user);
        $query->execute();
    }
    else{
        $bday = NULL;
    }
    if(isset($_POST['country'])){
        $country = $_POST['country'];
        $query = $mysqli->prepare("UPDATE users SET country=? WHERE user=?");
        $query->bind_param("ss", $country, $user);
        $query->execute();
    }
    else{
        $country = NULL;
    }
}
//If none were sent Exit
else{
    $response = [];
    $response["success"] = false;
    $response["message"] = "missing elements";
    echo json_encode($response);
    exit();
}

$response = [];
$response["success"] = true;
$response["message"] = "profile updated succesfully";
echo json_encode($response);

?>