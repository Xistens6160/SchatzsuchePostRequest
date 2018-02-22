<?php
$response = [];
$tempdata = [];
$tempdata = file_get_contents('highscore.txt');
$response = ["steps" => $tempdata["step"], "times" => $tempdata["time"]];
$json = json_encode($response);
echo $json;
