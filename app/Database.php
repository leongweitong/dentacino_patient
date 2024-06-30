<?php 
Trait Database{
    private function connect(){
        $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;

        $connect = new PDO($string, DBUSER, DBPASS);
        
        return $connect;
    }
    
}

