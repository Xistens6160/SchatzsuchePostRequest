<?php
/**
 * Created by PhpStorm.
 * User: gue
 * Date: 08.03.2018
 * Time: 16:20
 */

class Orte
{
    public $id;
    public $x;
    public $y;
    public $name;
    private $db;
    public $randomy;
    public $randomx;
    public $counter;

    function __construct($db, $id)
    {
        $this->db = $db;
        $sql = "SELECT * FROM orte WHERE id=$id";
        $dataarray = $this->db->getData($sql);
        $this->id = $dataarray["id"];
        $this->x = $dataarray["x"];
        $this->y = $dataarray["y"];
        $this->name = $dataarray["name"];
    }

    function updateGoalID()
    {
        $sql = "UPDATE orte SET name = 'Ziel' WHERE y = $this->randomy AND x = $this->randomx";
        $this->db->query($sql);
    }

    function updateStartID()
    {
        $sql = "UPDATE orte SET name = 'Start' WHERE y = $this->randomy AND x = $this->randomx";
        $this->db->query($sql);
    }

    function insertData()
    {
        $sql = "INSERT INTO orte SET x = " . $this->x . ", y = " . $this->y . ", name = 'Raum " . $this->counter . "'";
        $this->db->query($sql);
    }

    function selectStartID()
    {
        $sql = "SELECT id FROM orte WHERE name = 'Start'";
        $startid = $this->db->getInformation($sql, "id");
        return $startid;
    }

    function selectGoalID()
    {
        $sql = "SELECT id FROM orte WHERE x = $this->randomx AND y = $this->randomy";
        $goalid = $this->db->getInformation($sql, "id");
        return $goalid;
    }

    function clearTable()
    {
        $sql = "DELETE FROM orte";
        $this->db->query($sql);
    }

    function selectNextRoom()
    {
        $sql = "SELECT * FROM orte WHERE x= $this->x AND y= $this->y";
        $dataarray = $this->db->getData($sql);
        return $dataarray;
    }
}