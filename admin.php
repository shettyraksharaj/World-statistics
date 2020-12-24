<?php
session_start();
require 'database.php';
$sql = 'Select * from admin where admin_id = :id';
$addata = $data->prepare($sql);
$addata->execute(array(':id'=>$_SESSION['admin']));
if($row = $addata->fetch(PDO::FETCH_ASSOC)){
  $indexs = array_keys($row);
  foreach($indexs as $index) {
    $row[$index] = htmlentities($row[$index]);
  }
}
print_r($row);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add User</title>
  <?php require "iniconfig.php" ?>
</head>

<body>
  <?php require 'navbar.php' ?>
  <div class="container">
    <h2><?= $row['name']?>'s Profile:</h2>
    <div>
      <p>Name: <?= $row['name']?></p>
      <p>Email: <?= $row['admin_id']?></p>
    </div>
    <div>
      <button>Change Name</button>
      <button>change Email</button>
      <button>Change Password</button>
    </div>
    <div>
      <a href="#">Dark Mode:</a>
    </div>
    <div>
      <div><img src="<?= $row['admin_photo']?>" alt=""></div>
      <div><input type="file"></div>
    </div>
  </div>

</body>

</html>