<?php

$response = [];
$output = [];
$data = json_decode(file_get_contents("../json/map.json"));
$data = (array)$data;
//$map = (array)$data["TEst2"];
$map = (array)$data["field"];
//var_dump($map);
//$test = (array) $map[0];
//$test = (array) $test[1];
//var_dump((array)$test);
$coordsstart = (array)$data["start"];
$coordsgoal = (array)$data["goal"];
$position = [];

/**
 * @param $var
 * @param $action
 * @return string
 * generiert Button
 */
function getButtonHtml($var, $action)
{
    return "<button onclick='callAction($action)'>" . $var . "</button>";
}

/**
 * @return string
 * generiert den "Zurück zur Startseite" Button
 */
function getbackButton()
{
    return "<button onclick=\"location.href = '../html/start.html';\">Zurück zur Startseite</button>";
}

/**
 * startet ein neues Spiel beim Triggern
 */
function startNewGame()
{
    global $steps, $response, $position, $x, $y, $coordsstart,$map;
    $x = $coordsstart["x"];
    $y = $coordsstart["y"];
    file_put_contents('../Notes/currenttime.txt', time());
    $steps = 0;

    $roomArray = (array)$map[$x][$y];
    $response = ["art" => "Position: ", "output" => $roomArray["name"], "art2" => "", "steps" => "", "art3" => "", "time" => ""];
    $position = $map[$x][$y];
}

/**
 *  gibt die Position vor der Sackgasse aus
 */
function callLastPosition()
{
    global $map, $steps, $x, $y, $response;
    $x = file_get_contents("../Notes/lastx.txt");
    $y = file_get_contents("../Notes/lasty.txt");
    $roomArray = (array)$map[$x][$y];
    $response = ["art" => "Position: ", "output" => $roomArray["name"], "art2" => "Schritte: ", "steps" => $steps, "art3" => "", "time" => ""];
}

/**
 * gibt ein Tipp entsprechend der Position aus
 */
function callTipp()
{
    global $coordsgoal, $y, $x, $steps, $response;
    $goalx = $coordsgoal["x"];
    $goaly = $coordsgoal["y"];

    if ($goalx != $x) {
        if ($goalx > $x) {
            $answer = "Norden";
        } else {
            $answer = "Süden";
        }
    } else {
        if ($goaly > $y) {
            $answer = "Osten";
        } else {
            $answer = "Westen";
        }
    }
    $response = ["art" => "Tipp: ", "output" => "Gehe nach $answer", "art2" => "Schritte: ", "steps" => $steps, "art3" => "", "time" => ""];
}

/**
 * @param $action
 * gibt den nächsten Raum je nach Zug aus
 */
function callNextRoom($action)
{
    global $map, $y, $x, $steps, $response;
    file_put_contents('../Notes/lastx.txt', $x);
    file_put_contents('../Notes/lasty.txt', $y);
    if ($action == 1) {
        $x += 1;
    }
    if ($action == 2) {
        $y += 1;
    }
    if ($action == 3) {
        $x -= 1;
    }
    if ($action == 4) {
        $y -= 1;
    }

    // gibt bei leeren Feld "Sackgasse aus, sonst den ort der Koordinate
    if ((array)$map[$x][$y] != null) {
        $roomArray = (array)$map[$x][$y];
        $response = ["art" => "Position: ", "output" => $roomArray['name'], "art2" => "Schritte: ", "steps" => $steps, "art3" => "", "time" => ""];
    } else {
        $response = ["art" => "Position: ", "output" => "Sackgasse", "art2" => "Schritte: ", "steps" => $steps, "art3" => "", "time" => ""];
    }
}

/**
 * gibt die Knöpfe zum bewegen aus
 */
function callDirectionButton()
{
    global $response;
    $response['body'] = getButtonHtml('Norden', 1) . getButtonHtml('Osten', 2) . getButtonHtml('Süden', 3) . getButtonHtml('Westen', 4) . getButtonHtml('Tipp', 6) . getButtonHtml('Reset', 0);
}

/**
 * gibt die Sieges Oberfläche aus und speichert den Score
 */
function callVictoryScreen()
{
    global $map, $x, $y, $steps, $response;
    $beginntime = file_get_contents('../Notes/currenttime.txt') + 0;
    $time = time() - $beginntime;
    $position = 0;
    $roomArray = (array)$map[$x][$y];
    $response = ["art" => "Position: ", "output" => $roomArray["name"], "art2" => "Schritte: ", "steps" => $steps, "art3" => "Zeit in Sekunden: ", "time" => $time];
    $response['body'] = getbackButton();

    $score = file_get_contents('../json/highscore.json');
    $score = json_decode($score);
    $score[] = ["steps" => $steps, "time" => $time];
    $score = json_encode($score);
    file_put_contents('../json/highscore.json', $score);
}

// holt sich die Daten
$x = file_get_contents("../Notes/safex.txt");
$y = file_get_contents("../Notes/safey.txt");
$steps = file_get_contents("../Notes/currentstep.txt");

$action = $_POST['action'];

// setzt bei jedem Zug die Schrittzahl um ein hoch
if ($action >= 1 && $action <= 6) {
    $steps += 1;
}

// triggert beim laden der Seite und beim resetten des Spiels startNewGame
if ($action == 0) {
    startNewGame($map);
}

// triggert nach einer Sackgasse callLastPosition
if ($action == 5) {
    callLastPosition();
}

// triggert bei Anfrage callTipp
if ($action == 6) {
    callTipp();
}

// triggert callNextRoom mit der entsprechenden Raum in der Himmelsrichtung
if ($action >= 1 && $action <= 4) {
    callNextRoom($action);
}

// solange man nicht Gewonnen hat triggert callDirectionButton
if ($response["output"] != "Ziel") {
    callDirectionButton();
}

// triggert wenn man Gewonnen hat callVictoryScreen
if ($response["output"] == "Ziel") {
    callVictoryScreen();
}

// wenn die Antwort "Sackgasse" ist gibt er den Zurück Button aus
if ($response["output"] == "Sackgasse") {
    $response['body'] = getButtonHtml('Zurück', 5, $position);
}

// speichert Daten
file_put_contents("../Notes/safex.txt", $x);
file_put_contents("../Notes/safey.txt", $y);
file_put_contents("../Notes/currentstep.txt", $steps);

$json = json_encode($response);
echo $json;