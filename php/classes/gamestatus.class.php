<?php
/**
 * Created by PhpStorm.
 * User: gue
 * Date: 08.03.2018
 * Time: 13:33
 */

class Gamestatus
{
    private $id;
    public $starttime;
    public $currentstep;
    public $ort_id;
    public $last_ort_id;
    private $db;

    function __construct($db)
    {
        $this->db = $db;
        $sql = "SELECT * FROM gamestatus WHERE id='1'";
        $dataarray = $this->db->getData($sql);
        $this->id = $dataarray["id"];
        $this->starttime = $dataarray["starttime"];
        $this->currentstep = $dataarray["currentstep"];
        $this->ort_id = $dataarray["ort_id"];
        $this->last_ort_id = $dataarray["last_ort_id"];
    }

    function updateData()
    {

        $sql = "UPDATE gamestatus 
        SET currentstep = $this->currentstep,
            starttime = '.$this->starttime.',
             ort_id = '.$this->ort_id.',
            last_ort_id =" . $this->last_ort_id;
        $this->db->query($sql);
    }


}