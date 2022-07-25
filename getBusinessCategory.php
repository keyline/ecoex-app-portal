<?php
//session_start();
include_once('config.php');
extract($_POST);
	
        $cities = '<option value="">Select '.$_GET['name'].'</option>';
        $sql ="SELECT * FROM `ecoex_business_category` WHERE `parent` = '".$_GET['parent']."' AND published = 1";
        $query = $conn->query($sql);
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($rows as $row){ 
        $cities .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        
    echo $cities;
    
?>