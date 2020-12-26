<?php
session_start();
require 'database.php';
function gensalt()
    {
      $salt = "";
      for ($i = 0; $i < 10; $i++) {
        $r = chr(rand(37, 122));
        $salt = $salt . $r;
      }
      return $salt;
    }
function genhash($password, $salt){
      $pepper = "gh!#(dxgf500kl**o";
      $hash = $pepper . $password . $salt;
      for ($i = 0; $i < 30; $i++) {
        $hash = hash('md5', $hash);
      }
      return $hash;
    }


if ($_POST['function'] == 1) {
    $sal = gensalt();
    $hash =  genhash($_POST['npass'],$sal);
    $sql = 'UPDATE admin SET password = :pass, salt = :sal WHERE admin_id = :aid';
    $upnm = $data->prepare($sql);
    $upnm->execute(array(
        ':pass' => $hash,
        'sal'=>$sal,
        ':aid' => $_SESSION['admin']));
    echo 'true';
    
}else{
    $sql = 'Select * from admin where admin_id = :aid';
    $row = $data->prepare($sql);
    $row->execute(array(':aid' => $_SESSION['admin']));
    $value = $row->fetch(PDO::FETCH_ASSOC);
    $hash = genhash($_POST['cpass'],$value['salt']);
    if ($hash == $value['password']) {
        echo 'true';
    }else{
        echo 'false';
    }
}
?>