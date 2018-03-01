<?php

$maxX = $_GET['maxx'];
$maxY = $_GET['maxy'];
//$name = $_GET['name'];
$maxX = $maxX -1;
$maxY = $maxY -1;
//$map = file_get_contents('../json/map.json');
//$map = json_decode($map);
//$map = (array) $map;

$x = 0;
$y = 0;
$counter = 0;

/**
 * setz ein zufälligen Zielpunkt
 */
function newGoal()
{
    global $map, $maxY, $maxX,$name;
    $randomx = rand(0, $maxX);
    $randomy = rand(0, $maxY);
    if ($map[$name]["field"][$randomx][$randomy] != ["name" => "Start"]) {
        $map[$name]["field"][$randomx][$randomy]  = ["name" => "Ziel"];
        $map[$name]["goal"] = ["x" => $randomx, "y" => $randomy];
    } else {
        newGoal();
    }
}

/**
 * weißt jedem Raum in der X-Achse ein Wert zu
 * @param $x
 * @param $y
 */
function nextRoom($x, $y)
{
    global $maxY, $map, $counter, $x,$name;
    while ($y < $maxY) {
        $y += 1;
        $counter += 1;
//        $map[$name]["field"][$x][$y] = ["name" => "Raum" . $counter];
        $map["field"][$x][$y] = ["name" => "Raum" . $counter];
    }
    changex();
}

/**
 * geht wenn die X-Achse voll ist ein hoch
 */
function changex()
{
    global $x, $y, $maxX;

    if ($x < $maxX) {
        $y = -1;
        $x += 1;
        nextRoom($x, $y);
    }
}
//var_dump($map);
nextRoom($x, $y);

$randomx = rand(0, $maxX);
$randomy = rand(0, $maxY);
$map["field"][$randomx][$randomy] = ["name" => "Start"];
//$map[$name]["field"][$randomx][$randomy] = ["name" => "Start"];
//$map[$name]["start"] = ["x" => $randomx, "y" => $randomy];
$map["start"] = ["x" => $randomx, "y" => $randomy];


newGoal();
$json = json_encode($map);
file_put_contents('../json/map.json', $json);

header("location: ../html/start.html");