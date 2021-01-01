<?php
/*------start session-----*/
session_start();
require 'database.php';//add file to connect to database
/*-----SQL query to update Admin name with matching admin id-------*/
$sql = 'UPDATE admin SET name = :n WHERE admin_id = :aid';
$upnm = $data->prepare($sql);
$upnm->execute(array(
    ':n' => $_POST['adname'],
    ':aid' => $_SESSION['admin']));
/*-----SQL query to fetch the admin data with matching admin_if----*/
$sql = 'Select * from admin where admin_id = :aid';
$row = $data->prepare($sql);
$row->execute(array(':aid'=>$_SESSION['admin']));
echo json_encode($row->fetch(PDO::FETCH_ASSOC));//JSON encode the new name
?>
