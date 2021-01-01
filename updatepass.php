<?php
/*------start session-----*/
session_start();
require 'database.php';//add file to connect to database
/*---function to generate salt----*/
function gensalt()
    {
      $salt = "";
      for ($i = 0; $i < 10; $i++) {
        $r = chr(rand(37, 122));
        $salt = $salt . $r;
      }
      return $salt;
    }
/*----password to hash the password----*/
function genhash($password, $salt){
      $pepper = "gh!#(dxgf500kl**o";
      $hash = $pepper . $password . $salt;
      for ($i = 0; $i < 30; $i++) {
        $hash = hash('md5', $hash);
      }
      return $hash;
    }

if ($_POST['function'] == 1) {
    /*-------update existing password-----*/
    $sal = gensalt();//calling gensalt() function
    $hash =  genhash($_POST['npass'],$sal);//generating hash from the password and salt
    /*-----SQL query to update the existing password-----*/
    $sql = 'UPDATE admin SET password = :pass, salt = :sal WHERE admin_id = :aid';
    $upnm = $data->prepare($sql);
    $upnm->execute(array(
        ':pass' => $hash,
        'sal'=>$sal,
        ':aid' => $_SESSION['admin']));
    echo 'true';//return true
    
}else{
    /*---------check if the current password id true--------*/
    /*----SQL query to fetch data from database with matching admin id----*/
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_SESSION['admin']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    $hash = genhash($_POST['cpass'],$value['salt']);//generate the hash 
    if ($hash == $value['password']) {//check if the hash are equal
        echo 'true';//return true
    }else{
        echo 'false';//return false
    }
}
?>