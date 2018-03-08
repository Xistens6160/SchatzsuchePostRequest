<?php
ini_set("display_errors",1);
include "classes/database.class.php";

$db = new Database();
$db->connect("192.168.58.193", "schatzsuche@%", "Passw0rd!", "schatzsuche");


$maxX = $_GET['maxx'];
$maxY = $_GET['maxy'];
$maxX = $maxX -1;
$maxY = $maxY -1;
$x = 0;
$y = -1;
$counter = 0;

/**
 * setz ein zufälligen Zielpunkt
 */
function newGoal()
{
    global $maxY, $maxX, $db;
    $randomx = rand(0, $maxX);
    $randomy = rand(0, $maxY);
    $sql = "SELECT id FROM orte WHERE name = 'Start'";
    $startid = $db->getInformation($sql, "id");
    $sql = "SELECT id FROM orte WHERE x = $randomx AND y = $randomy";
    $goalid = $db->getInformation($sql, "id");


    if ($goalid != $startid) {
        $sql = "UPDATE orte SET name = 'Ziel' WHERE y = $randomy AND x = $randomx";
        $db->query($sql);

        $sql = "UPDATE map SET start = '.$startid.', goal = '.$goalid.' WHERE id='1'";
        $db->query($sql);
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
    global $maxY, $counter, $sql, $db;

    while ($y < $maxY) {
        $y += 1;
        $counter += 1;
        $sql = "INSERT INTO orte SET x = ".$x.", y = ".$y.", name = 'Raum ".$counter."'";
        $db->query($sql);
    }
    changex();
}

/**
 * geht wenn die X-AChse voll ist ein hoch
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

$sql = "DELETE FROM orte";
$db->query($sql);

nextRoom($x, $y);


$randomx = rand(0, $maxX);
$randomy = rand(0, $maxY);
$sql = "UPDATE orte SET name = 'Start' WHERE y = $randomy AND x = $randomx";
$db->query($sql);

newGoal();

header("location: ../html/start.html");