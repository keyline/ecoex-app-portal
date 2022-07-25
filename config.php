<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "keyline1_ecoex_portal";
 
$dsn = 'mysql:dbname=' . $database . ';host=' . $server;

$conn = new PDO($dsn, $username, $password);
?>