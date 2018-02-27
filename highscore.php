<?php
    function calllist($step, $time)
    {
        return   "<tr><td>".$step."</td> <td>".$time."</td></tr>";
    };

    function getTableHtml($tabledata) {
        $html = '<table style="width: 50%;margin-left: 25%; text-align: center;border: solid">
                <tr>
                <th>Steps</th>
                <th>Time</th>
                </tr>';
        $html .= $tabledata;

        $html .= '</table>';
        return $html;
    }

    // holt sich die Scores aus der Text Datei
    $response = [];
    $json = file_get_contents('highscore.txt');
    $tempdata = json_decode($json);

    // sortiert die Liste nach den Schritten aufsteigend
    asort($tempdata);
    $tabledata = '';

    // triggert für jeden Eintrag die Function um die Daten in die Tabelle zu Speichern
    foreach ($tempdata as $row)
    {
        $row = (array) $row;
        $steps = $row["steps"];
        $time = $row["time"];
        $tabledata .= calllist($steps, $time);
    }
    $response['body'] = getTableHtml($tabledata);
    $json = json_encode($response);
    echo $json;

