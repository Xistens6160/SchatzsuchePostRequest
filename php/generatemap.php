<?php
ini_set("display_errors",1);
$servername = "192.168.58.193";
$username = "schatzsuche@%";
$password = "Passw0rd!";
$dbname = "schatzsuche";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
    global $map, $maxY, $maxX, $conn, $startid, $goalid;
    $randomx = rand(0, $maxX);
    $randomy = rand(0, $maxY);
    $sql = "SELECT id FROM orte WHERE name = 'Start'";
    $resultstart = mysqli_query($conn, $sql);
    $startarray = mysqli_fetch_assoc($resultstart);
    $sql = "SELECT id FROM orte WHERE x = $randomx AND y = $randomy";
    $resultgoal = mysqli_query($conn, $sql);
    $goalidarray = mysqli_fetch_assoc($resultgoal);
    $startid = $startarray["id"];
    $goalid = $goalidarray["id"];


    if ($goalid != $startid) {
        $sql = "UPDATE orte SET name = 'Ziel' WHERE y = $randomy AND x = $randomx";
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO map SET start = '.$startid.', goal = '.$goalid.'";
        mysqli_query($conn, $sql);
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
    global $maxY, $counter, $sql, $conn, $map;

    while ($y < $maxY) {
        $y += 1;
        $counter += 1;
        $sql = "INSERT INTO orte SET x = ".$x.", y = ".$y.", name = 'Raum ".$counter."'";
        mysqli_query($conn,$sql);
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
mysqli_query($conn,$sql);
$sql = "DELETE FROM map";
mysqli_query($conn,$sql);

nextRoom($x, $y);


$randomx = rand(0, $maxX);
$randomy = rand(0, $maxY);
$sql = "UPDATE orte SET name = 'Start' WHERE y = $randomy AND x = $randomx";
mysqli_query($conn,$sql);

newGoal();

header("location: ../html/start.html");