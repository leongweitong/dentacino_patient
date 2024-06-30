<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
require_once "../app/Database.php";

Class Service{
    use Database;
    private $con="";
    public function __construct(){
        $this->con = $this->connect(); 
    }
    function getServiceTypeDetail(){
        $stmt = $this->con->prepare("SELECT * FROM service_type where ServiceType_Status = 1");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
}
?>