<?php
session_start();
include_once('config.php');
extract($_POST);

$sql ="SELECT * FROM `ecoex_company` WHERE `c_name` = '".$companyName."' ";
$query2 = $conn->query($sql);
$companyData = $query2->fetch(PDO::FETCH_LAZY);
	
if(isset($companyData['c_name'])){
    
$sql ="SELECT * FROM `ecoex_user_table` WHERE `c_id` = '".$companyData['c_id']."' ";
$query2 = $conn->query($sql);
$companyUserData = $query2->fetch(PDO::FETCH_LAZY);

if(isset($companyUserData['user_name'])){
    if($companyUserData['user_email_auth'] == '1'){
        $data["success"] = 'true';
    } else {
        $data["success"] = 'false';
    }
} else {
    $data["success"] = 'false';
}
} else {
    $data["success"] = 'false';
}
echo json_encode($data);
?>