<?php
session_start();
if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}
if (isset($_POST['Add'])) {
  if (isset($_FILES['Image']) && $_FILES['Image']['name'] != '') {
    $imagename = $_FILES["Image"]['name'];
    $imageiniloc = $_FILES["Image"]['tmp_name'];
    $imagesize = $_FILES["Image"]['size'];
    $imageuperr = $_FILES["Image"]['error'];
    $extyp = array("jpeg", "jpg", "gif", "png");
    $exp = explode(".", $imagename);
    $imgext = end($exp);
    $imgNloc = "admin_photos" . "/" . time() . "." . $imgext;
    if ($imageuperr == 0) {
      if ($imagesize < 1024000) {
        if (in_array($imgext, $extyp)) {
          $img = new Imagick($imageiniloc);
          $img->thumbnailImage(100, 100);
          $img->writeImage($imageiniloc);
          if (!move_uploaded_file($imageiniloc, $imgNloc)) {
            $_SESSION['error'] = "Error: Unable to upload";
            header("location:adduser.php");
            return;
          }
        } else {
          $_SESSION['error'] = "Invalid Format";
          header("location:adduser.php");
          return;
        }
      } else {
        $_SESSION['error'] = "Image size too large";
        header("location:adduser.php");
        return;
      }
    } else {
      $_SESSION['error'] = "Error:Unable to upload";
      header("location:adduser.php");
      return;
    }
  } else {
    $imgNloc = "admin_photos/profile-user.svg";
  }
  if (isset($_POST['Pass'])) {
    function gensalt()
    {
      $salt = "";
      for ($i = 0; $i < 10; $i++) {
        $r = chr(rand(37, 122));
        $salt = $salt . $r;
      }
      return $salt;
    }
    function genhash($password, $salt)
    {
      $pepper = "gh!#(dxgf500kl**o";
      $hash = $pepper . $password . $salt;
      for ($i = 0; $i < 30; $i++) {
        $hash = hash('md5', $hash);
      }
      return $hash;
    }
    $sal = gensalt();
    $hashpass = genhash($_POST['Pass'], $sal);
    require 'database.php';
    $sql = $data->prepare('INSERT INTO ADMIN (admin_id,name,password,salt,admin_photo) VALUES (:ADI,:NAM,:PASS,:SAL,:ADP)');
    $sql->execute(array(
      ':ADI' => $_POST['Admin_id'],
      ':NAM' => $_POST['name'],
      ':PASS' => $hashpass,
      ':SAL' => $sal,
      ':ADP' => $imgNloc
    ));
    header("location:adduser.php");
    return;
  }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Add Admin</title>
  <?php require "iniconfig.php" ?>
</head>

<body>
  <!-----------------------navbar----------------------->
  <?php require 'navbar.php' ?>

  <!-------------------------------------content--------------------------->
  <div class="container">
    <div class="row">
      <h2>Add user</h2>
    </div>
    <div class="container">
      <form method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="Admin_id">Admin ID: </label>
          <div class="row">
            <input class="form-control col-4" type="email" name="Admin_id" id="Admin_id">
            <div class="" id="invalid-id" style="Display:none;">
              Invalid ID.
            </div>
            <div class="" id="taken-id" style="Display:none;">
              ID already taken.
            </div>
          </div>
          <label for="RAdmin_id">Confirm Admin ID:</label>
          <div class="row">
            <input class="form-control col-4" type="email" name="Radmin_id" id="RAdmin_id">
            <div class="invalid-feedback">
              IDs don't match.
            </div>
          </div>
          <label for="name">Name</label>
          <div class="row">
            <input class="form-control col-4" type="text" name="name">
          </div>
          <label for="pass">Password:</label>
          <div class="row">
            <input class="form-control col-4" type="password" name="Pass" id="pass">
            <div class="invalid-feedback">
              Enter Password.
            </div>
          </div>
          <label for="Rpass">Confirm Password:</label>
          <div class="row">
            <input class="form-control col-4" type="password" name="Rpass" id="Rpass">
            <div class="invalid-feedback">
              Password does not match.
            </div>
          </div>
          <label for="photo">Admin Photo: </label>
          <input class="form-control-file" type="file" name="Image" id="photo">
          <p class="text-danger">
            <?php
            if (isset($_SESSION['error'])) {
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            }
            ?>
          </p>
        </div>
        <button class="btn btn-primary" type="submit" name="Add" id="add">Add</button>
      </form>
    </div>
  </div>
  <div class="position-absolute imgprew">
    <img src="admin_photos/profile-user.svg" alt="" id="imgPreview">
    <br>
    <p class="text-center"><b>Preview:</b></p>
  </div>

  <script type="text/javascript">
    /*--function to preview images--*/
    $(document).ready(() => {
      $('#photo').change(function() {
        const file = this.files[0];
        console.log(file);
        if (file) {
          let reader = new FileReader();
          reader.onload = function(event) {
            console.log(event.target.result);
            $('#imgPreview').attr('src', event.target.result);
          }
          reader.readAsDataURL(file);
        }
      });
    });
    /*--function to validate--*/
    $("#add").click(function(event) {
      var pass1 = $('#pass').val();
      var pass2 = $('#Rpass').val();
      var id1 = $('#Admin_id').val();
      var id2 = $('#RAdmin_id').val();
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if (id1 != "") {
        if (!regex.test(id1)) {
          event.preventDefault();
          $("#Admin_id").attr("class", "form-control col-4 is-invalid");
          $("#invalid-id").attr("class", "invalid-feedback");
          $("#invalid-id").attr("style", "display:block;");
        } else {
          $("#Admin_id").attr("class", "form-control col-4");
          $("#invalid-id").attr("class", " ");
          $("#invalid-id").attr("style", "display:none;");
          $.post('updatemail.php', {
            ademail: id1,
            function: 0
          }, function(data, status) {
            console.log(data);
            if (data == 'true') {
              $("#Admin_id").attr("class", "form-control col-4");
              $("#taken-id").attr("class", " ");
              $("#taken-id").attr("style", "display:none;");
              if (id1 != id2) {
                event.preventDefault();
                $("#Admin_id").attr("class", "form-control col-4 is-invalid");
                $("#RAdmin_id").attr("class", "form-control col-4 is-invalid");
              } else {
                $("#Admin_id").attr("class", "form-control col-4 is-valid");
                $("#RAdmin_id").attr("class", "form-control col-4 is-valid");
              }
            } else {
              event.preventDefault();
              $("#Admin_id").attr("class", "form-control col-4 is-invalid");
              $("#taken-id").attr("class", "invalid-feedback");
              $("#taken-id").attr("style", "display:block;");
            }
          });
        }
      } else {
        event.preventDefault();
        $("#Admin_id").attr("class", "form-control col-4 is-invalid");
        $("#invalid-id").attr("class", "invalid-feedback");
        $("#invalid-id").attr("style", "display:block;");
      }
      if (pass1 != "") {
        if (pass1 != pass2) {
          event.preventDefault();
          $("#Rpass").attr("class", "form-control col-4 is-invalid");
          $("#pass").attr("class", "form-control col-4 is-invalid");
        } else {
          $("#Rpass").attr("class", "form-control col-4 is-valid");
          $("#pass").attr("class", "form-control col-4 is-valid");
        }
      } else {
        event.preventDefault();
        $("#pass").attr("class", "form-control col-4 is-invalid");
      }
    });
  </script>
</body>

</html>