<!--controller-->
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/*-----------starting a session----------------*/
session_start();

$adidbar = ((isset($_SESSION['adidbar'])? $_SESSION['adidbar']:'<input class="form-control" type="email" name="Admin_id" placeholder="sugarkitty@cat.com">') );
$paswdbar = ((isset($_SESSION['paswdbar'])? $_SESSION['paswdbar']:'<input class="form-control" type="password" name="Password">') );
/*---------connecting to database-------------------*/
require 'database.php';
/*----function to generate hash-------*/
function genhash($password, $salt){
  $pepper="gh!#(dxgf500kl**o";
  $hash = $pepper.$password.$salt;
  for($i=0;$i<30;$i++){
    $hash = hash('md5',$hash);
  }
  return $hash;

}
/*--------check if cancel button has been clicked--------*/
if(isset($_POST['Cancel'])) {
  header("location:index.php");//redirect to index page
  return;
}

/*------------------check if login putton has been clicked-------*/
if(isset($_POST['Login'])){
  if(isset($_POST['Admin_id']) && strlen($_POST['Admin_id'])>0){
    /*------fetching userdata from database-------*/
    try {
      $se = $data->query('SELECT * FROM admin WHERE admin_id= "'.$_POST['Admin_id'].'"');
      $admindata = $se->fetch();
    } catch (\Exception $e) {
      echo("Exception message:".$e->getMessage());
      return;
    }
    /*----checking if admin id exists----*/
    if (isset($admindata['admin_id'])) {
      /*--checking the password--*/
      if(isset($_POST['Password']) && strlen($_POST['Password'])>0){
        $hashpass = genhash($_POST['Password'],$admindata['salt']);
        /*----comparing password---*/
        if ($hashpass == $admindata['password']) {
          $_SESSION['admin'] = $admindata['admin_id'];
          $_SESSION['propho'] = $admindata['admin_photo'];
          $_SESSION['name'] = $admindata['name'];
          header("location:admindataview.php");
          return;
        }else{
          $_SESSION['paswdbar'] = '<input class="form-control is-invalid" type="password" name="Password"><div class="invalid-feedback">Wrong Password.</div>';
          header('location:wldstatadminlogin.php');
          return;
        }
      }else {
        $_SESSION['paswdbar'] = '<input class="form-control is-invalid" type="password" name="Password"><div class="invalid-feedback">Enter a Password.</div>';
        header('location:wldstatadminlogin.php');
        return;
            }
    }else{
      $_SESSION['adidbar'] = '<input class="form-control is-invalid" type="email" name="Admin_id" placeholder="sugarkitty@cat.com"><div class="invalid-feedback">Account does not exist</div>';
      header('location:wldstatadminlogin.php');
      return;
    }
  }else{
    $_SESSION['adidbar'] = '<input class="form-control is-invalid" type="email" name="Admin_id" placeholder="sugarkitty@cat.com"><div class="invalid-feedback">Enter valid credentials</div>';
    $_SESSION['paswdbar'] = '<input class="form-control is-invalid" type="password" name="Password"><div class="invalid-feedback">Enter valid cerdentials.</div>';
    header('location:wldstatadminlogin.php');
    return;
  }
}
 ?>
<!--view-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Admin-Login</title>
    <?php require 'iniconfig.php'; ?>
  </head>
  <body class="logback">
    <!----------login box------------>
    <div class="container">
      <div class="border m-auto logbox shadow-lg p-5 bg-white rounded" id='box' style='display:none;'>
        <h4 class="text-center pb-3">Admin Login</h4>
        <form method="post">
          <div class="from-group px-4">
            <label for="username">Admin username:</label>
            <?php
            echo $adidbar;
            $_SESSION['adidbar'] = '<input class="form-control" type="email" name="Admin_id" placeholder="sugarkitty@cat.com">';
             ?>
          </div>
          <div class="form-group px-4">
            <label for="password">Password:</label>
            <?php
            echo $paswdbar;
            $_SESSION['paswdbar'] = '<input class="form-control" type="password" name="Password">';
             ?>
          </div>
          <div class="form-group px-4 mx-auto row">
            <button  class=" mx-auto btn btn-primary" type="submit" name="Login" value="Login">Login</button>
            <button   class="mx-auto btn btn-danger" type="submit" name="Cancel" value="Cancel">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <script>
      /*---Javascript to add animation----*/
    $(window).on('load',function(){
      $('#box').fadeIn(600);
    })
    </script>
  </body>
</html>

