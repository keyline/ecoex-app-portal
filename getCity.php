<?php
session_start();
include_once('config.php');
extract($_POST);
	
        $cities = '<option>Select City</option>';
        $sql ="SELECT * FROM `ecoex_city` WHERE `districtid` = '".$_GET['distId']."'   ";
        $query = $conn->query($sql);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){ 
        $cities .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        
    echo $cities;
    
?>