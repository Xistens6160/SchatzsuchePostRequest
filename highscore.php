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

    $counter = 0;
    $response = [];
    $json = file_get_contents('highscore.txt');
    $tempdata = json_decode($json);
    asort($tempdata);
    $tabledata = '';
    foreach ($tempdata as $row)
    {
        $row = (array) $row;
        $steps = $row["step"];
        $time = $row["time"];
        $tabledata .= calllist($steps, $time);
    }
    $response['body'] = getTableHtml($tabledata);
    $json = json_encode($response);
    echo $json;

