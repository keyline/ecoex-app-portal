<?php
session_start();
include_once('config.php');
extract($_POST);
	
        $cities = '<option>Select District</option>';
        $sql ="SELECT * FROM `ecoex_district` WHERE `state_id` = '".$_GET['stateId']."'   ";
        $query = $conn->query($sql);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){ 
        $cities .= '<option value="'.$row['districtid'].'">'.$row['district_title'].'</option>';
        }
        
    echo $cities;
    
?>