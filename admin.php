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
if (isset($_POST['submit'])) {
  if (isset($_FILES['adph']) && $_FILES['adph']['name'] != '') {
    $adphname = $_FILES["adph"]['name'];
    $adphiniloc = $_FILES["adph"]['tmp_name'];
    $adphsize = $_FILES["adph"]['size'];
    $adphuperr = $_FILES["adph"]['error'];
    $extyp = array("jpeg", "jpg", "gif", "png");
    $exp = explode(".", $adphname);
    $imgext = end($exp);
    $imgNloc = "admin_photos" . "/" . time() . "." . $imgext;
    echo $adphiniloc;
    if ($adphuperr == 0) {
      if ($adphsize < 1024000) {
        if (in_array($imgext, $extyp)) {
          $img = new Imagick($adphiniloc);
          $img->thumbnailImage(100, 100);
          $img->writeImage($adphiniloc);
          if (!move_uploaded_file($adphiniloc, $imgNloc)) {
            $_SESSION['error'] = "Error: Unable to upload";
            header("location:admin.php");
            return;
          }
        } else {
          $_SESSION['error'] = "Invalid Format";
          header("location:admin.php");
          return;
        }
      } else {
        $_SESSION['error'] = "adph size too large";
        header("location:admin.php");
        return;
      }
    } else {
      $_SESSION['error'] = "Error:Unable to upload";
      header("location:admin.php");
      return;
    }
  } else {
    $imgNloc = "admin_photos/profile-user.svg";
  }
  $sql = 'UPDATE admin SET admin_photo = :ph WHERE admin_id = :aid';
  $upad = $data->prepare($sql);
  $upad->execute(array(
    ':ph' => $imgNloc,
    ':aid' => $row['admin_id']
  ));
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
      <div class="row mt-5">
        <div class="col-4 shadow-lg rounded mr-5">
          <div class="mt-4">
            <h4>Deatils:</h4>
            <div class=" mt-2 ml-5">
              <p class="font-weight-bold" style="font-size: 130%;">Name: <span id="namefield" class="font-weight-normal"><?= $row['name'] ?></span</p> <p class="font-weight-bold" style="font-size: 130%;">Email: <span id="emailfield" class="font-weight-normal"><?= $row['admin_id'] ?></span></p>
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
        <div class=" col-6  ml-5">
          <div class="container">
          <div class="shadow-lg rounded mb-4 ">
              <div class="py-3 my-auto-2" style=" width:100%;margin:0px;">
                <span class="Font-weight-bold ml-4 mt-2 mb-n1" style="font-size: 110%; ">Dark Mode:  </span>  <span><label class="switch">
                    <input type="checkbox">
                    <span class="slider round"></span>
                  </label></span>
              </div>
            </div>
            <div class=" shadow-lg rounded">
                <h4 class=" pl-3 pt-3">Profile Photo:</h4> 
                <div class="row">
                <img class="rounded-circle mx-auto" src="<?= $row['admin_photo'] ?>" style=" border:4px solid #000000;width:30%">
                </div>
                <div class="row mt-3 pb-3">
                <button class="btn btn-primary mx-auto " data-toggle="modal" data-target="#adminphotoM">Change</button>
                </div>
            </div>
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
          <button type="button" class="btn btn-primary" id="namesave">Save</button>
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
            <div class=" container form-group">
              <div class="row">
                <label for="email1">Enter Email:</label>
                <input class="form-control " type="text" id="email1">
                <div class="" id="invalid-id" style="Display:none;">
                  Invalid ID.
                </div>
                <div class="" id="taken-id" style="Display:none;">
                  ID already taken.
                </div>
              </div>
              <div class="row">
                <label for="email">Confirm Email:</label>
                <input type="text" name="email2" id="email2" class="form-control">
                <div class="invalid-feedback">
                  IDs don't match.
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="emailsave">Save</button>
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
              <div>
                <label for="pass">Enter Current password:</label>
                <input type="password" name="pass" id="cpass" class="form-control">
                <div class="" id='incorrectpass' style="Display:none;">
                  Incorrect Password.
                </div>
                <div class="" id="nopass" style="Display:none;">
                  Enter password.
                </div>
              </div>
              <div>
                <label for="npass">Enter New Password</label>
                <input type="password" name="npass" id="npass" class="form-control">
                <div class="invalid-feedback" id="nopass2">
                  Enter Password.
                </div>
              </div>
              <div>
                <label for="npass">Confirm Password</label>
                <input type="password" name="npass" id="cnpass" class="form-control">
                <div class="invalid-feedback">
                  Password does not match.
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='passsave'>Save</button>
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
          <form method="post" enctype="multipart/form-data">
            <div class="form-group">
              <input class="form-file-control" type="file" name="adph">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="submit">Save</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</body>
<script>
  /*-----------username------------*/
  $('#namesave').click(function(event) {
    var name = $('#name').val();
    $.post('updatename.php', {
      adname: name
    }, function(data, status) {
      console.log(status);
      data = JSON.parse(data);
      $('#namefield').html(data.name);
      $('#prname').html(data.name);
    });
  });

  /*-------------email---------------*/
  $('#emailsave').click(function(event) {
    var id1 = $('#email1').val();
    var id2 = $('#email2').val();
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (id1 != "") {
      $.post('updatemail.php', {
        ademail: id1,
        function: 0
      }, function(data, status) {
        console.log(data);
        if (data == 'true') {
          $("#email1").attr("class", "form-control");
          $("#taken-id").attr("class", " ");
          $("#taken-id").attr("style", "display:none;");
          if (!regex.test(id1)) {
            $("#email1").attr("class", "form-control is-invalid");
            $("#invalid-id").attr("class", "invalid-feedback");
            $("#invalid-id").attr("style", "display:block;");
          } else {
            $("#email1").attr("class", "form-control");
            $("#invalid-id").attr("class", " ");
            $("#invalid-id").attr("style", "display:none;");
            if (id1 != id2) {
              $("#email1").attr("class", "form-control is-invalid");
              $("#email2").attr("class", "form-control is-invalid");
            } else {
              $("#email1").attr("class", "form-control is-valid");
              $("#email2").attr("class", "form-control is-valid");
              $.post('updatemail.php', {
                ademail: id1,
                function: 1
              }, function(data, status) {
                console.log(status);
                data = JSON.parse(data);
                console.log(data);
                $('#emailfield').html(data.admin_id);
              });
            }
          }
        } else {
          $("#email1").attr("class", "form-control is-invalid");
          $("#taken-id").attr("class", "invalid-feedback");
          $("#taken-id").attr("style", "display:block;");
        }
      });
    } else {
      $("#email1").attr("class", "form-control is-invalid");
      $("#invalid-id").attr("class", "invalid-feedback");
      $("#invalid-id").attr("style", "display:block;");
    }
  });

  /*-------------pass---------------*/
  $('#passsave').click(function(event) {
    var cpass = $('#cpass').val();
    var npass = $('#npass').val();
    var cnpass = $('#cnpass').val();
    if (cpass != '') {
      $("#cpass").attr("class", "form-control");
      $("#nopass").attr("class", " ");
      $("#nopass").attr("style", "display:none;");
      $.post('updatepass.php', {
        cpass: cpass,
        function: 0
      }, function(data, status) {
        console.log(data);
        if (data == 'true') {
          console.log('correct');
          $("#cpass").attr("class", "form-control is-valid");
          if (npass != '') {
            $("#npass").attr("class", "form-control is-valid");
            if (npass == cnpass) {
              $("#cnpass").attr("class", "form-control is-valid");
              $.post('updatepass.php', {
                npass: npass,
                function: 1
              }, function(data, status) {
                console.log(data);
              });
            } else {
              $("#npass").attr("class", "form-control is-invalid");
              $("#nopass2").attr("style", "display:none");
              $("#cnpass").attr("class", "form-control is-invalid");
            }
          } else {
            $("#npass").attr("class", "form-control is-invalid");
          }
        } else {
          console.log('incorrect');
          $("#cpass").attr("class", "form-control is-invalid");
          $("#incorrectpass").attr("class", "invalid-feedback");
          $("#incorrectpass").attr("style", "display:block;");
        }
      });
    } else {
      $("#cpass").attr("class", "form-control is-invalid");
      $("#nopass").attr("class", "invalid-feedback");
      $("#nopass").attr("style", "display:block;");
    }
  });
</script>

</html>