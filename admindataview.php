<?php
session_start();
if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}
require 'database.php';
$thsql = 'SELECT * FROM COUNTRY JOIN CRIME JOIN ECONOMY JOIN EDU_AND_HEALTH JOIN ENVIROMENT JOIN MILITARY JOIN POPULATION JOIN TECHNOLOGY WHERE COUNTRY.CON_ID = CRIME.CON_ID AND COUNTRY.CON_ID = ECONOMY.CON_ID AND COUNTRY.CON_ID = EDU_AND_HEALTH.CON_ID AND COUNTRY.CON_ID = ENVIROMENT.CON_ID AND COUNTRY.CON_ID = MILITARY.CON_ID AND COUNTRY.CON_ID = POPULATION.CON_ID AND COUNTRY.CON_ID = TECHNOLOGY.CON_ID';
$tabledata = $data->prepare($thsql);
$tabledata->execute();
$rows;
if($rows = $tabledata->fetchall(PDO::FETCH_ASSOC)){
  $rowcount = count($rows);
  $index = array_keys($rows[0]);
  for($i=0; $i < $rowcount; $i++){
    foreach($index as $y){
      $rows[$i][$y] = $rows[$i][$y]? $rows[$i][$y] : '-';
      $rows[$i][$y] = htmlentities($rows[$i][$y]);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Database Editior</title>
  <?php require 'iniconfig.php' ?>
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
        <a href="admin.php"> <img class="rounded-circle" src="<?= $_SESSION['propho'] ?>" alt=""></a>
      </li>
      <li class="nav-item mx-1">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </nav>
  <div class="container" >
    <h2>View Data:</h2>

    <!--******************************__table navbar__************************************-->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item ml-auto" role="presentation">
        <a class="nav-link active" href="#population" id="population-tab" data-toggle="tab" role="tab" aria-controls="population" aria-selected="false">Population</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#economy" id="economy-tab" data-toggle="tab" role="tab" aria-controls="economy" aria-selected="false">Economy</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#enviroment" id="enviroment-tab" data-toggle="tab" role="tab" aria-controls="enviroment" aria-selected="false">Enviroment</a>
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
      <div class="tab-pane fad show container active" id="population" role="tabpanel" aria-labelledby="population-tab"> 
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>Flag</th>
              <th>Population</th>
              <th>Birth Rate(%)</th>
              <th>Death Rate(%)</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td style='width:12%;'><img style='width:45%;' src='".$rows[$i]['FLAG']."'></td><td>".$rows[$i]['POPULATION']."</td><td>".$rows[$i]['BIRTH_RATE']."</td><td>".$rows[$i]['DEATH_RATE']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--_____________________________economy________________________________-->
      <div class="tab-pane fade container" id="economy" role="tabpanel" aria-labeledby="economy-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>GDP($)</th>
              <th>Percapita($) </th>
              <th>Poverty Percentage(%)</th>
              <th>Currency</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['GDP']."</td><td>".$rows[$i]['PERCAPITA']."</td><td>".$rows[$i]['POVERTY_PER']."</td><td>".$rows[$i]['CURRENCY']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete' ><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--______________________________enviroment___________________________________-->
      <div class="tab-pane fade container" id="enviroment" role="tabpanel" aria-labelledby="enviroment-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>EPI Score</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['EPI_INDEX']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!---_________________________________military___________________________________-->
      <div class="tab-pane fade container" id="military" role="tabpanel" aria-labelledby="military-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>Budget($)</th>
              <th>Personnel</th>
              <th>Nuclear Warhead</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['BUDGET']."</td><td>".$rows[$i]['PERSONNEL']."</td><td>".$rows[$i]['NUCLEAR_WARHEAD']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--___________________________________crime_________________________________-->
      <div class="tab-pane fade container" id="crime" role="tabpanel" aria-labelledby="crime-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>Crime Rate(%)</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['CRIME_RATE']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--________________________________________techonology_______________________________-->
      <div class="tab-pane fade container" id="contribution" role="tabpanel" aria-labelledby="contribution-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>Cited Document</th>
              <th>Citable Document</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['CITED_DOC']."</td><td>".$rows[$i]['CITABLE_DOC']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--__________________________________education and health______________________________-->
      <div class="tab-pane fade container" id="eduhealth" role="tabpanel" aria-labelledby="eduhealth-tab">
      <table class="Table">
          <thead>
            <tr>
              <th>Country</th>
              <th>Health Index</th>
              <th>Literacy Rate</th>
              <th>Life Expectancy</th>
              <th>Education Budget</th>
              <th>Options</th>
            </tr>
          </thead>
          <tbody>
            <?php
            for($i=0; $i < $rowcount; $i++){
              echo "<tr><td>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['HEALTH_INDEX']."</td><td>".$rows[$i]['LITERACY_RATE']."</td><td>".$rows[$i]['LIFE_EXPECTANCY']."</td><td>".$rows[$i]['EDU_BUDGET']."</td><td style='width:15%;'><a href='update.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Edit'><img style='width:30%;' src='editicon.svg'></a>/<a href='delete.php?id=".$rows[$i]['CON_ID']."' data-toggle='tooltip' data-placement='top' title='Delete'><img style='width:30%;' src='delicon.svg'></a></td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <!--________________________end of tab content for table________________________-->
  </div>
</body>

</html>