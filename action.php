<?php
$response =[];
$output = [];

// orte.php einbinden
include 'orte.php';

// map.php einbinden
include 'map.php';

// aktuellen Actionwert von der JS Function holen
$action = $_POST['action'];

// aktuelle Schritte holen
$steps = file_get_contents('currentstep.txt');

// aktuelle Position holen
$position = file_get_contents('position.txt');

// generiert Button mit gewünschten Werten
function getButtonHtml($var, $action) {
    return "<button onclick='callAction($action)'>".$var."</button>";
}

// generiert Button der auf deie Startseite leitet
function getbackButton(){
    return "<button onclick=\"location.href = 'start.html';\">Zurück zur Startseite</button>";
}


// gibt den Starttext aus und setzt Position und den Schrittzähler auf 0 zurück
if ($action == 0)
{
    file_put_contents('currenttime.txt',time());
    $steps = 0;
    $position = 0;
    $zufall = array_rand($starttext,1);
    $tempoutput = $starttext[$zufall];
    $response = ["art" => "", "output" => $tempoutput["start"],"art2" =>"", "beschreibung" => "","art3" => "",  "steps" => "",  "art4" => "", "time" => ""];
}

// erhöht den Schrittzähler um eins, wenn ein Zug gemacht wird
if ($action >= 1 && $action <= 6)
{
    $steps = $steps + 1;
}


// gibt ein Tipp entsprechend der Position aus
if ($action == 6)
{
    $templocation = $map[$position];
    $response = ["art" => "Tipp: ", "output" => $templocation["tipp"],"art2" => "", "beschreibung" => "","art3" => "Schritte: ",  "steps" => $steps,  "art4" => "", "time" => ""];
}

// gibt den letzten Ort wo man war aus
if ($action == 5)
{
    $position = file_get_contents("lastposition.txt");
    $templocation = $map[$position];
    $response = ["art" => "Ort: ", "output" => $templocation["name"], "art2" => "Beschreibung: ", "beschreibung" => $templocation["beschreibung"], "art3" => "Schritte: ",  "steps" => $steps,  "art4" => "", "time" => ""];
}

// ändert die Position und gibt neue Position aus
if ($action >= 1 && $action <= 4)
{
    file_put_contents('lastposition.txt', $position);
    $templocation = $map[$position];
    if ($action == 1)
    {
        $position = $templocation["norden"];
    }
    if ($action == 2)
    {
        $position = $templocation["osten"];
    }
    if ($action == 3)
    {
        $position = $templocation["süden"];
    }
    if ($action == 4)
    {
        $position = $templocation["westen"];
    }
    $templocation = $map[$position];
    $response = ["art" => "Ort: ", "output" => $templocation["name"], "art2" => "Beschreibung: ", "beschreibung" => $templocation["beschreibung"], "art3" => "Schritte: ",  "steps" => $steps, "art4" => "", "time" => ""];
    $postionrequest = $templocation;
}


// gibt die Button der Züge die man machen kann aus
if ($postionrequest["id"] != 8)
{
    $response['body'] = getButtonHtml('Norden',1)
        . getButtonHtml('Osten', 2)
        . getButtonHtml('Süden', 3)
        . getButtonHtml('Westen', 4)
        . getButtonHtml('Tipp', 6)
        . getButtonHtml('Reset',0);
}

// gibt den "Zurück zum Startbildschirm" Button und Sieges Text aus
if ($postionrequest["id"] == 8)
{
    $beginntime = file_get_contents('currenttime.txt') + 0;
    $time =  time() - $beginntime;
    $position = 0;
    $response = ["art" => "Ort: ", "output" => $templocation["name"], "art2" => "Beschreibung: ", "beschreibung" => $templocation["beschreibung"], "art3" => "Schritte: ",  "steps" => $steps, "art4" => "Zeit in Sekunden: ","time" => $time];
    $response['body'] = getbackButton();
    $score = ["step" => $steps, "time" => $time];
    $score = json_encode($score);
    file_put_contents('highscore.txt', $score);
}

// gibt den "Zurück" Button aus
if ($postionrequest["id"] == 9)
{
    $response['body'] = getButtonHtml('Zurück', 5,$position);
}

// schreibt die neue Schrittzahl in eine andere Datei
file_put_contents('currentstep.txt', $steps);

// schreibt die neue Position in eine andere Datei
 file_put_contents('position.txt', $position);

// verpackt alles in JSON
$json = json_encode($response);
echo $json;