<?php
session_start();
include_once('config.php');
extract($_POST);
	
        $cities = '<option>Select District</option>';
        $sql ="SELECT * FROM `ecoex_target_by_district` WHERE `state_id` = '".$_GET['stateId']."' && `target_id` = '".$_GET['targetId']."'   ";
        $query = $conn->query($sql);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){ 

$sql ="SELECT * FROM `ecoex_district` WHERE `districtid` = '".$row['distrcit_id']."' ";
$query2 = $conn->query($sql);
$companyData = $query2->fetch(PDO::FETCH_LAZY);

        $cities .= '<option value="'.$companyData['districtid'].'">'.$companyData['district_title'].'</option>';
        }
        
    echo $cities;
    
?>