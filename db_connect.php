<?php 
    function db_iconnect($dbName) {
        $un = "root";
        $pw = "+0j8ci*Bpfh->Dwt";
        $db = $dbName;
        $hostname = "localhost";
        $dblink = new mysqli($hostname, $un, $pw, $db);
        return $dblink;
    }
?>