<?php
$maxX = 2;
$maxY = 2;
$x = 0;
$y = 0;
$counter = 0;


$map[$x][$y] = ["name" => "Start"];
nextRoom($x, $y);

function nextRoom($x, $y)
{
    global $maxY, $map, $counter, $x;
    while ($y < $maxY){
        $y+=1;
        $counter+=1;
        $map[$x][$y] = ["name" => "Raum".$counter];
    }
    changey();
}

function changey(){
    global $x,$y, $maxX;

        if ($x < $maxX)
        {
            $y = -1;
            $x+=1;
            nextRoom($x, $y);
         }
}

$json = json_encode($map);
file_put_contents('map.json',$json);

header("location: start.html");