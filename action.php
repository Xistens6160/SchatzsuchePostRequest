<?php
$response =[];
$output = array();
include 'orte.php';
$action = $_POST['action'];

function getButtonHtml($var, $action) {
    return "<button onclick='callAction($action);'>".$var."</button>";
}

function getbackButton(){
    return "<button onclick=\"location.href = 'start.html';\">Zurück zur Startseite</button>";
}


if ($action == 1 || 2 || 3 || 4){
    $zufall = array_rand($ort, 1);
    $temp = $ort[$zufall];
    $response = ["art" => "Ort: ", "output" => $temp["name"],"art2" => "Beschreibung: ", "beschreibung" => $temp["Beschreibung"]];
    $gewonnen = $temp;
}

if ($action == 0)
{
    $zufall = array_rand($starttext,1);
    $temp = $starttext[$zufall];
    $response = ["art" => "", "output" => $temp["start"],"art2" =>"", "beschreibung" => ""];
}

if ($action == 6){
    $zufall = array_rand($tipp,1);
    $temp  = $tipp[$zufall];
    $response = ["art" => "Tipp: ", "output" => $temp["tipp"],"art2" => "", "beschreibung" => ""];
}

if ($gewonnen != ["name" => "Schatz gefunden", "Beschreibung" => "Du hast Gewonnen"]) {
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
$json = json_encode($response );
echo $json;