<?php
session_start();

if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}

require 'database.php';

$sql = 'Select * from admin where admin_id = :id';
$addata = $data->prepare($sql);
$addata->execute(array(':id' => $_SESSION['admin']));
if ($row = $addata->fetch(PDO::FETCH_ASSOC)) {
  $indexs = array_keys($row);
  foreach ($indexs as $index) {
    $row[$index] = htmlentities($row[$index]);
  }
}
$_SESSION['propho'] = $row['admin_photo'];
print_r($row);


if (isset($_POST['submit'])) {
  if (isset($_FILES['adph'])&&$_FILES['adph']['name']!='') {
    $adphname = $_FILES["adph"]['name'];
    $adphiniloc = $_FILES["adph"]['tmp_name'];
    $adphsize = $_FILES["adph"]['size'];
    $adphuperr = $_FILES["adph"]['error'];
    $extyp = array("jpeg", "jpg", "gif", "png");
    $exp = explode(".",$adphname);
    $imgext = end($exp);
    $imgNloc = "admin_photos"."/".time().".".$imgext;
    echo $adphiniloc;
  if ($adphuperr == 0) {
    if ($adphsize<1024000) {
      if (in_array($imgext,$extyp)) {
        $img = new Imagick($adphiniloc);
        $img->thumbnailImage(100,100);
        $img->writeImage($adphiniloc);
        if (!move_uploaded_file($adphiniloc,$imgNloc)) {
          $_SESSION['error'] = "Error: Unable to upload";
          header("location:admin.php");
          return;
        }
      }else {
        $_SESSION['error'] = "Invalid Format";
        header("location:admin.php");
        return;
      }
    }else {
      $_SESSION['error'] = "adph size too large";
      header("location:admin.php");
      return;
    }
  }else {
    $_SESSION['error'] = "Error:Unable to upload";
    header("location:admin.php");
    return;
  }
  }else{
      $imgNloc = "admin_photos/profile-user.svg";
  }
  $sql = '  UPDATE `admin` SET admin_photo = :ph WHERE admin_id = :aid';
  $upad = $data->prepare($sql);
  $upad->execute(array(
                      ':ph' => $imgNloc,
                      ':aid' => $row['admin_id']));
  header('location:admin.php');
  return;
}

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
  <div class="container mt-4">
    <h2><?= $row['name'] ?>'s Profile:</h2>
    <div class="container">
      <div class="row">
        <div class="col-6">
          <div class="mt-4">
            <h4>Deatils:</h4>
            <div class=" mt-2 ml-5">
              <p class="font-weight-bold" style="font-size: 130%;">Name: <span class="font-weight-normal"><?= $row['name'] ?></span</p> <p class="font-weight-bold" style="font-size: 130%;">Email: <span class="font-weight-normal"><?= $row['admin_id'] ?></span></p>
            </div>
          </div>
          <div class="my-4">
            <h4>Change Credentials:</h4>
            <div class="ml-5">
              <button class="btn btn-primary mt-4 mb-2 d-block" data-toggle="modal" data-target="#usernameM">Change Name</button>
              <button class="btn btn-primary my-2 d-block" data-toggle="modal" data-target="#useremailM">change Email</button>
              <button class="btn btn-primary my-2 d-block" data-toggle="modal" data-target="#passwordM">Change Password</button>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="my-5 row">
            <div class="col-3">
              <p class="Font-weight-bold" style="font-size: 110%;">Dark Mode: </p>
            </div>
            <div class="col-3">
              <span><label class="switch">
                  <input type="checkbox">
                  <span class="slider round"></span>
                </label></span>
            </div>
          </div>
          <div class="mt-5">
            <h4>Profile Photo:</h4>
            <div><img class="rounded-circle" src="<?= $row['admin_photo'] ?>" style=" border:4px solid #000000;width:20%"></div>
            <br>
            <button class="btn btn-primary" data-toggle="modal" data-target="#adminphotoM">Change</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!----------modal-1------------->
  <div class="modal fade" id="usernameM" tabindex="-1" aria-labelledby="usernamemodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Username:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method=post>
            <div class="form-group">
              <label for="name">Enter name:</label>
              <input type="text" name="username" id="name" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!----------modal-2------------->
  <div class="modal fade" id="useremailM" tabindex="-1" aria-labelledby="useremailmodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Email id:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method=post>
            <div class="form-group">
              <label for="email">Enter Email:</label>
              <input type="Email" name="email" id="email" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!----------modal-3------------->
  <div class="modal fade" id="passwordM" tabindex="-1" aria-labelledby="passwordmodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Password:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method=post>
            <div class="form-group">
              <label for="pass">Enter Current password:</label>
              <input type="password" name="pass" id="pass" class="form-control">
              <label for="npass">Enter New Password</label>
              <input type="password" name="npass" id="npass" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!----------modal-4------------->
  <div class="modal fade" id="adminphotoM" tabindex="-1" aria-labelledby="photomodal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change Profile Photo:</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="post" enctype="multipart/form-data" >
        <div class="form-group">
              <input class="form-file-control" type="file" name="adph">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="submit" >Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>