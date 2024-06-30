<?php

class ClosureDate
{
    use Database;
    private $con = "";
    public function __construct()
    {
        $this->con = $this->connect();
    }
    function getClosureDateDetails()
    {
        $stmt = $this->con->prepare("SELECT * FROM closure_date ORDER BY DATE ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}