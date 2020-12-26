<?php
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
  <?php require'navbar.php'?>


    <div class="container" >
    <h2>Purge Data in Database:</h2>
    <p><i class="fas fa-exclamation"></i> <b>Warning:</b> Purging the Database will result in permanent loss of Data. </p>
    <button type='button' class='btn btn-danger purgebtn' id='purgebtn' >Purge Database</button>
    </div>
    <div style='display:none; background:rgba(0,0,0,0.8);' id='alertwindow'>
            <div id='alertbox'>
            <i class="fas fa-exclamation-triangle"></i>
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
