<?php
    $response = [];
    $filename = 'maps.txt';

if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $maps = json_decode($json);
    if (!is_array($maps)) $maps = [];
}
else
{
    $maps = [];
}

$maps[] = [
    0 =>["id" =>  0, "name" => "Eigenes Haus", "beschreibung" => "Aus deinem Haus kommt ein leckerer Geruch, wie es aussieht kocht deine Mutter gerade", "norden" => rand(0,9), "osten" =>  rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Osten"],
    1 =>["id" =>  1, "name" => "Markplatz", "beschreibung" => "Der Markplatz ist reichlich Besucht von Händlern aus der ganzen Welt....", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Norden"],
    2 =>["id" =>  2, "name" => "Schmied", "beschreibung" => "Du siehst wie der Schmied das neue Schwert schleift", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Osten"],
    3 =>["id" =>  3, "name" => "Kirche", "beschreibung" => "Du siehst ein Prister der vor einer kleinen Menschengruppe eine Predigt hält", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Osten"],
    4 =>["id" =>  4, "name" => "Rathaus", "beschreibung" => "Vor dem Rathaus ist ein kleiner Stand aufgebaut wo die Bürger ihre Steuern zahlen müssen", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Norden"],
    5 =>["id" =>  5, "name" => "Wirtshaus", "beschreibung" => "Schon von draußen hörst du das gebrülle und gelache der Besoffenen Gäste", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Norden"],
    6 =>["id" =>  6, "name" => "Burgtor", "beschreibung" => "Das Burgtor ist stark von Wachen bewacht, du hast keine Chance da durch zu kommen", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "Geh nach Osten"],
    7 =>["id" =>  7, "name" => "Seitengasse", "beschreibung" => "In der Gasse stinkt es nach Fäkalien und du siehst ein paar Kerle beim Würfel spielen", "norden" => rand(0,9), "osten" => rand(0,9), "süden" => rand(0,9), "westen" => rand(0,9), "tipp" => "geh nach Osten"],
    8 =>["id" =>  8, "name" => "Schatz", "beschreibung" => "Du hast den Schatz gefunden!!!!"],
    9 =>["id" =>  9, "name" => "Sackgasse", "beschreibung" => "Du kommst hier nicht weiter"]];

$json = json_encode($maps);
var_dump($json);
file_put_contents($filename, $json);

//header("Location: start.html");

