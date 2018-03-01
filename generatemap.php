<?php
$maxX = $_GET['maxX'];
$maxY = $_GET['maxY'];
$x = 0;
$y = 0;
$counter = 0;

function newGoal()
{
    global $map, $maxY, $maxX;
    $randomx = rand(0, $maxX);
    $randomy = rand(0, $maxY);
    if ($map["field"][$randomx][$randomy] != ["name" => "Start"]) {
        $map["field"][$randomx][$randomy] = ["name" => "Ziel"];
        $map["goal"] = ["x" => $randomx, "y" => $randomy];
    }
    else
    {
        newGoal();
    }
}

function nextRoom($x, $y)
{
    global $maxY, $map, $counter, $x;
    while ($y < $maxY) {
        $y += 1;
        $counter += 1;
        $map["field"][$x][$y] = ["name" => "Raum" . $counter];
    }
    changex();
}

function changex()
{
    global $x, $y, $maxX;

    if ($x < $maxX) {
        $y = -1;
        $x += 1;
        nextRoom($x, $y);
    }
}

nextRoom($x, $y);

$randomx = rand(0, $maxX);
$randomy = rand(0, $maxY);
$map["field"][$randomx][$randomy] = ["name" => "Start"];
$map["start"] = ["x" => $randomx, "y" => $randomy];

newGoal();



$json = json_encode($map);
file_put_contents('map.json', $json);

header("location: start.html");