<?php

class Highscore
{
    public $id;
    public $steps;
    public $time;
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function putScore()
    {
        $sql = "INSERT INTO highscore SET steps =$this->steps, times = $this->time";
        $this->db->query($sql);
    }

    function displayData()
    {
        $sql = "SELECT * FROM highscore";
        $results = $this->db->query($sql);
        while ($row = mysqli_fetch_assoc($results)) {
            $tempdata[] = ["steps" => $row["steps"], "time" => $row["times"]];
        }
        return $tempdata;
    }
}