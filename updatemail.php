<?php
/*------start session-----*/
session_start();
require 'database.php'; //add file to connect to database

if ($_POST['function'] == 1) {
    /*--------update the email id-------*/
    /*-----SQL query to update the admin email id-----*/
    $sql = 'UPDATE admin SET admin_id = :n WHERE admin_id = :aid';
    $upnm = $data->prepare($sql);
    $upnm->execute(array(
        ':n' => $_POST['ademail'],
        ':aid' => $_SESSION['admin']
    ));
    /*-----SQL query to get the updated data from the database----*/
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_POST['ademail']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    session_destroy();//end existing session
    session_start();//start a new session
    $_SESSION['admin'] = $value['admin_id'];//assign new session values
    $_SESSION['propho'] = $value['admin_photo'];
    $_SESSION['name'] = $value['name'];
    echo json_encode($value);//encode the value into JSON format
} else {
    /*--------check if the mail id is already taken----*/
    /*----SQL to fetch the row with matching admin id----*/
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_POST['ademail']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    if ($value) {//check if id exists
        echo 'false';//return false
    }else{
        echo 'true';//return true
    }

}
