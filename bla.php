<?php
$score = [0 => ["steps" => 2, "time" => 3]];
$json = json_encode($score);
file_put_contents('highscore.txt', $json);
