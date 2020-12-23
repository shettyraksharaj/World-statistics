<?php
session_start();
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
          <a class="nav-link dropdown-toggle active" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admineditsingle.php">single entry</a>
            <a class="dropdown-item active" href="admineditmulti.php">batch edit</a>
          </div>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="adduser.php">Add User</a>
        </li>
      </ul>
      <ul class="nav nav-pills float-left">
       <li>
         <a href="admin.php"> <img class="rounded-circle" src="<?= $_SESSION['propho']?>" alt=""></a>
       </li>
       <li class="nav-item mx-1">
         <a class="nav-link" href="logout.php">Logout</a>
       </li>
      </ul>
    </nav>
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item ml-auto" role="presentation">
        <a class="nav-link" href="#insert" id="insert-tab" data-toggle="tab" role="tab" aria-controls="insert" aria-selected="true">Insert from a file</a>
      </li>
      <li class="nav-item mr-auto" role="presentation">
        <a class="nav-link" href="#purge" id="purge-tab" data-toggle="tab" role="tab" aria-controls="purge" aria-selected="false">Super purge</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade show active container" id="insert" role="tabpanel" aria-labelledby="insert-tab">

      </div>
      <div class="tab-pane fade container" id="purge" role="tabpanel" aria-labelledby="purge-tab">
          <button type='button' class='btn btn-danger purgebtn' id='purgebtn' >Purge Database</button>
      </div>
    </div>
    <div style='display:none;' id='alertwindow'>
            <div id='alertbox'>
              <p>you sure?</p>
              <div>
                <button class='btn btn-primary' id='confirm'>Yes</button>
                <button class='btn btn-danger' id='cancel'>Cancel</button>
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
