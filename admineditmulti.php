<?php
session_start();
session_start();
if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Database Editior</title>
    <?php require 'iniconfig.php'?>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand">DATABASE EDITIOR</a>
      <ul class="nav nav-pills ml-3 mr-auto">
        <li class="nav-item mx-1">
          <a class="nav-link" href="admindataview.php">View Table</a>
        </li>
        <li class="nav-item dropdown mx-1 ">
          <a class="nav-link dropdown-toggle active" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert and Purge</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admineditsingle.php">Data Entry</a>
            <a class="dropdown-item active" href="admineditmulti.php">Purge Data</a>
          </div>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="adduser.php">Add Admin</a>
        </li>
      </ul>
      <ul class="nav nav-pills float-left">
      <li style="border-left: 1px solid #000000;" >
         <a style="margin-left: 5px;" href="admin.php"> <img class="rounded-circle" src="<?= $_SESSION['propho']?>" alt=""> <span><?= $_SESSION['name']?></span> </a>
       </li>
       <li class="nav-item mx-1">
         <a class="nav-link" href="logout.php">Logout</a>
       </li>
      </ul>
    </nav>
    <div class="container" >
    <h2>Purge Data in Database:</h2>
    <p><b>Warning:</b> Purging the Database will result in permanent loss of Data. </p>
    <button type='button' class='btn btn-danger purgebtn' id='purgebtn' >Purge Database</button>
    </div>
    <div style='display:none;' id='alertwindow'>
            <div id='alertbox'>
              <p>Clicking on Yes will empty the Database are you sure.</p>
              <div class="row">
                <button class='btn btn-primary mx-auto' id='confirm'>Yes</button>
                <button class='btn btn-danger mx-auto' id='cancel'>Cancel</button>
              </div>
            </div>
          </div>
    <script>
      $('#purgebtn').click(function(){
        $("#alertwindow").fadeIn(500);
      });
      $('#cancel').click(function(){
        $('#alertwindow').attr('style','display:none;');
      });
      $('#confirm').click(function(){
        $.post('purge.php');
        $('#alertwindow').attr('style','display:none;');
      });
    </script>
  </body>
</html>
