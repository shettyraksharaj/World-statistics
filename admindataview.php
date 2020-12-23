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
          <a class="nav-link active" href="admindataview.php">View Table</a>
        </li>
        <li class="nav-item dropdown mx-1">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert</a>
          <div class="dropdown-menu">
            <a class="dropdown-item " href="admineditsingle.php">single entry</a>
            <a class="dropdown-item" href="admineditmulti.php">batch edit</a>
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
    <!--******************************__table navbar__************************************-->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item ml-auto" role="presentation">
        <a class="nav-link" href="#population" id="population-tab" data-toggle="tab" role="tab" aria-controls="population" aria-selected="false">Population</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#economy" id="economy-tab" data-toggle="tab" role="tab" aria-controls="economy" aria-selected="false">Economy</a>
      </li>
      <li class="nav-item" role="presentation">
        <a  class="nav-link" href="#enviroment" id="enviroment-tab" data-toggle="tab" role="tab" aria-controls="enviroment" aria-selected="false">Enviroment</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#military" id="military-tab" data-toggle="tab" role="tab" aria-controls="military" aria-selected="false">Mititary</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#crime" id="crime-tab" data-toggle="tab" role="tab" aria-controls="crime" aria-selected="false">Crime</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#contribution" id="contribution-tab" data-toggle="tab" role="tab" aria-controls="contribution" aria-selected="false">Contribution To Techonology</a>
      </li>
      <li class="nav-item mr-auto" role="presentation">
        <a class="nav-link" href="#eduhealth" id="eduhealth-tab" data-toggle="tab" role="tab" aria-controls="eduhealth" aria-selected="false">Education and Health</a>
      </li>
    </ul>
    <!--________________________________tab content for table__________________________________-->
    <div class="tab-content">
                <!--_____________________________population________________________________-->
      <div class="tab-pane fade container" id="population" role="tabpanel" aria-labelledby="population-tab">

      </div>
                <!--_____________________________economy________________________________-->
      <div class="tab-pane fade container" id="economy" role="tabpanel" aria-labeledby="economy-tab">

      </div>
      <!--______________________________enviroment___________________________________-->
      <div class="tab-pane fade container" id="enviroment" role="tabpanel" aria-labelledby="enviroment-tab">

      </div>
      <!---_________________________________military___________________________________-->
      <div class="tab-pane fade container" id="military" role="tabpanel" aria-labelledby="military-tab">

      </div>
      <!--___________________________________crime_________________________________-->
      <div class="tab-pane fade container" id="crime" role="tabpanel" aria-labelledby="crime-tab">

      </div>
      <!--________________________________________techonology_______________________________-->
      <div class="tab-pane fade container" id="contribution" role="tabpanel" aria-labelledby="contribution-tab">

      </div>
      <!--__________________________________education and health______________________________-->
      <div class="tab-pane fade container" id="eduhealth" role="tabpanel" aria-labelledby="eduhealth-tab">

      </div>
    </div>
    <!--________________________end of tab content for table________________________-->
  </div>
  </body>
</html>