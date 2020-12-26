<?php
session_start();
require 'database.php';
$sql = 'UPDATE admin SET name = :n WHERE admin_id = :aid';
$upnm = $data->prepare($sql);
$upnm->execute(array(
    ':n' => $_POST['adname'],
    ':aid' => $_SESSION['admin']));
$sql = 'Select * from admin where admin_id = :aid';
$row = $data->prepare($sql);
$row->execute(array(':aid'=>$_SESSION['admin']));
echo json_encode($row->fetch(PDO::FETCH_ASSOC));
?>
