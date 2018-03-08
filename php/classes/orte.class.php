<?php
/**
 * Created by PhpStorm.
 * User: gue
 * Date: 08.03.2018
 * Time: 16:20
 */

class Orte
{
    public  $id;
    public  $x;
    public  $y;
    public  $name;
    private $db;

    function __construct($db,$id)
    {
        $this->db = $db;
        $sql = "SELECT * FROM orte WHERE id=$id";
        $dataarray = $this->db->getData($sql);
        $this->id = $dataarray["id"];
        $this->x  = $dataarray["x"];
        $this->y  = $dataarray["y"];
        $this->name = $dataarray["name"];
    }

    function insertData()
    {

    }
}