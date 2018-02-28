<?php
$response =[];
$output = [];
$map = json_decode(file_get_contents("map.json"));
$map = (array) $map;
$position = [];

// hohlt sich die Daten
$x = file_get_contents("Notes/safex.txt");
$y = file_get_contents("Notes/safey.txt");
$steps = file_get_contents("Notes/currentstep.txt");

$action = $_POST['action'];

// generiert Button
function getButtonHtml($var, $action) {
    return "<button onclick='callAction($action)'>".$var."</button>";
}

// generiert den "Zurück zur Startseite" Button
function getbackButton(){
    return "<button onclick=\"location.href = 'start.html';\">Zurück zur Startseite</button>";
}

// startet ein neues Spiel beim Triggern
function startNewGame($map){
    global $steps, $response,$position, $x, $y;
    $x = 0;
    $y = 0;
    file_put_contents('Notes/currenttime.txt',time());
    $steps = 0;

    $roomArray = (array) $map[$x][$y];
    $response = ["art" => $roomArray['name'], "steps" => ""];
    $position = $map[$x][$y];
}

// setzt bei jedem Zug die Schrittzahl um ein hoch
if ($action >= 1 && $action <= 6)
{
    $steps += 1;
}

// triggert startNewGame
if($action == 0)
{
startNewGame($map);
}

// gibt nach einer Sackgasse die letzte Position aus und setzt x und y dem entsprechend
if ($action == 5)
{
    $x = file_get_contents("Notes/lastx.txt");
    $y = file_get_contents("Notes/lasty.txt");
    $response = $roomArray = (array)$map[$x][$y];
    $response = ["art" => $roomArray['name'],"steps" => $steps];
}

// ändert die Koordinaten je nach Richtung
if ($action >= 1 && $action <= 4)
{
    file_put_contents('Notes/lastx.txt', $x);
    file_put_contents('Notes/lasty.txt', $y);
    if ($action == 1)
    {
        $x += 1;
    }
    if ($action == 2)
    {
        $y += 1;
    }
    if ($action == 3)
    {
        $x -= 1;
    }
    if ($action == 4)
    {
        $y -= 1;
    }

    // gibt bei leeren Feld "Sackgasse aus, sonst den ort der Koordinate
    if ((array) $map[$x][$y] != null)
    {
        $response = $roomArray = (array)$map[$x][$y];
        $response = ["art" => $roomArray['name'],"steps" => $steps];
    }
    else
    {
        $response = ["art" => "Sackgasse","steps" => $steps];
        $templocation = $response;
    }
//    $postionrequest = $templocation;
}

// solange man nicht Gewonnen hat gibt er die Button der Züge aus
if ($postionrequest["name"] != "Gewonnen")
{
    $response['body'] = getButtonHtml('Norden',1)
        . getButtonHtml('Osten', 2)
        . getButtonHtml('Süden', 3)
        . getButtonHtml('Westen', 4)
//        . getButtonHtml('Tipp', 6)
        . getButtonHtml('Reset',0);
}

//if ($postionrequest["name"] == "Gewonnen")
//{
//    $beginntime = file_get_contents('Notes/currenttime.txt') + 0;
//    $time =  time() - $beginntime;
//    $position = 0;
//    $response = $map[$x][$y];
//    $response['body'] = getbackButton();
//
//    $score = file_get_contents('highscore.json');
//    $score = json_decode($score);
//    $score[] = ["steps" => $steps, "time" => $time];
//    $score = json_encode($score);
//    file_put_contents('highscore.json', $score);
//}

// wenn die Antwort "Sackgasse" ist gibt er den Zurück Button aus
if ($templocation["art"] == "Sackgasse")
{
    $response['body'] = getButtonHtml('Zurück', 5,$position);
}

// speichert Daten
file_put_contents("Notes/safex.txt", $x);
file_put_contents("Notes/safey.txt", $y);
file_put_contents("Notes/currentstep.txt",$steps);

$json = json_encode($response);
echo $json;