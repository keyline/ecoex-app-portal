<?php
$server = "localhost";
$username = "keyline1_userecoex";
$password = "1Hw,WnixY{nx";
$database = "keyline1_ecoex1_protal";
 
$dsn = 'mysql:dbname=' . $database . ';host=' . $server;

$conn = new PDO($dsn, $username, $password);
?>