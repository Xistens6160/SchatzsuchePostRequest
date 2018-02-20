<?php
$response =[];
include 'orte.php';
$action = $_POST['action'];



if ($action == 1 || 2 || 3 || 4){
    $zufall = array_rand($ort, 1);
    $response["ort"] = $ort[$zufall];
}

if ($action == 0)
{
    $zufall = array_rand($starttext,1);
    $response["start"] = $starttext[$zufall];
}

if ($action == 6){
    $zufall = array_rand($tipp,1);
    $response["tipp"] = $tipp[$zufall];
}


$json = json_encode($response );
echo $json;