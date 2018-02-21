<?php
$response =[];
$output = array();
include 'orte.php';
include 'map.php';
//aktuellen Actionwert von der JS Function holen
$action = $_POST['action'];
//aktuelle Position holen
$position = file_get_contents('position.txt');

//Generiert Button mit gewünschten Werten
function getButtonHtml($var, $action) {
    return "<button onclick='callAction($action)'>".$var."</button>";
}

//Generiert Button der auf deie Startseite leitet
function getbackButton(){
    return "<button onclick=\"location.href = 'start.html';\">Zurück zur Startseite</button>";
}


//Gibt den Starttext aus und setzt Position auf 0 zurück
if ($action == 0)
{
    $position = 0;
    $zufall = array_rand($starttext,1);
    $temp = $starttext[$zufall];
    $response = ["art" => "", "output" => $temp["start"],"art2" =>"", "beschreibung" => ""];
}
//Gibt ein Tipp entsprechend der Position aus
if ($action == 6){
    $temp2 = $map[$position];
    $response = ["art" => "Tipp: ", "output" => $temp2["tipp"],"art2" => "", "beschreibung" => ""];
}
//Gibt den Letzten Ort wo man war aus
if ($action == 5){
    $position = file_get_contents("lastposition.txt");
    $temp2 = $map[$position];
    $response = ["art" => "Ort: ", "output" => $temp2["name"], "art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
}

//Ändert die Position und gibt neue Position aus
if ($action == 1 ||$action == 2 || $action == 3 || $action == 4) {
    file_put_contents('lastposition.txt', $position);
    $temp = $map[$position];
    if ($action == 1) {
        $position = $temp["norden"];
    }
    if ($action == 2) {
        $position = $temp["osten"];
    }
    if ($action == 3) {
        $position = $temp["süden"];
    }
    if ($action == 4) {
        $position = $temp["westen"];
    }
    $temp2 = $map[$position];
    $response = ["art" => "Ort: ", "output" => $temp2["name"], "art2" => "Beschreibung: ", "beschreibung" => $temp2["beschreibung"]];
    $postionrequest = $temp2;
}

//gibt die Button der Züge die man machen kann aus
if ($postionrequest["id"] != 8){
    $response['body'] = getButtonHtml('Norden',1)
        . getButtonHtml('Osten', 2)
        . getButtonHtml('Süden', 3)
        . getButtonHtml('Westen', 4)
        . getButtonHtml('Tipp', 6);
}
//gibt den "Zurück zum Startbildschirm" Button aus
if($postionrequest["id"] == 8)
{
    $position = 0;
    $response['body'] = getbackButton();
}
//Gibt den "Zurück" Button aus
if ($postionrequest["id"] == 9)
{
    $response['body'] = getButtonHtml('Zurück', 5,$position);
}
//Schreibt die neue Position in eine andere Datei
 file_put_contents('position.txt', $position);
//verpackt alles in JSON
$json = json_encode($response);
echo $json;