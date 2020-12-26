<?php
session_start();
require 'database.php';
if ($_POST['function'] == 1) {
    $sql = 'UPDATE admin SET admin_id = :n WHERE admin_id = :aid';
    $upnm = $data->prepare($sql);
    $upnm->execute(array(
        ':n' => $_POST['ademail'],
        ':aid' => $_SESSION['admin']
    ));
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_POST['ademail']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    session_destroy();
    session_start();
    $_SESSION['admin'] = $value['admin_id'];
    $_SESSION['propho'] = $value['admin_photo'];
    $_SESSION['name'] = $value['name'];
    echo json_encode($value);
} else {
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_POST['ademail']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    if ($value) {
        echo 'false';
    }else{
        echo 'true';
    }

}
