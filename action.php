<?php
$response =[];
$output = array();
include 'orte.php';
include 'map.php';
$action = $_POST['action'];

function getButtonHtml($var, $action, $player) {
    return "<button onclick='callAction($action,$player);'>".$var."</button>";
}

function getbackButton(){
    return "<button onclick=\"location.href = 'start.html';\">Zurück zur Startseite</button>";
}



if ($action == 0)
{
    $zufall = array_rand($starttext,1);
    $temp = $starttext[$zufall];
    $response = ["art" => "", "output" => $temp["start"],"art2" =>"", "beschreibung" => ""];
}

if ($action == 6){
$temp2 = $map[$player];
$response = ["art" => "Tipp: ", "output" => $temp2["tipp"],"art2" => "", "beschreibung" => ""];
}

if ($action == 1)
{
    $temp = $map[$player];
    $player = $temp["norden"];
    $temp2 = $map[$player];
    $response = ["art" => "Ort: ", "output" => $temp2["name"],"art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
    $gewonnen = $temp2;
}
if ($action == 2)
{
    $temp = $map[$player];
    $player = $temp["osten"];
    $temp2 = $map[$player];
    $response = ["art" => "Ort: ", "output" => $temp2["name"],"art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
    $gewonnen = $temp2;
}
if ($action == 3)
{
    $temp = $map[$player];
    $player = $temp["süden"];
    $temp2 = $map[$player];
    $response = ["art" => "Ort: ", "output" => $temp2["name"],"art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
    $gewonnen = $temp2;
}
if ($action == 4)
{
    $temp = $map[$player];
    $player = $temp["westen"];
    $temp2 = $map[$player];
    $response = ["art" => "Ort: ", "output" => $temp2["name"],"art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
    $gewonnen = $temp2;
}

if ($gewonnen["name"] != "Schatz gefunden") {
    $response['body'] = getButtonHtml('Norden', 1)
        . getButtonHtml('Osten', 2)
        . getButtonHtml('Süden', 3)
        . getButtonHtml('Westen', 4)
        . getButtonHtml('Tipp', 6);
}
else
{
    $response['body'] = getbackButton();
}


$json = json_encode($response);
echo $json;