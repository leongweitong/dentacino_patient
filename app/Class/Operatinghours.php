<?php
require_once "../app/Database.php"; 

class Operatinghours{
    use Database;
    private $con="";
    public function __construct(){
        $this->con = $this->connect(); 
    }

    function getoperatinghours(){
        $sql = " SELECT MIN(Start_Time) as start_time, MAX(End_Time) as end_time 
        FROM operating_hours 
        WHERE Operatinghours_Status = '2';";
        $stmt = $this->con->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }

    function getlunchtime(){
        $sql = " SELECT MIN(Start_Time) as start_time, MAX(End_Time) as end_time 
        FROM operating_hours 
        WHERE Operatinghours_Status = '1';";
        $stmt = $this->con->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }
}