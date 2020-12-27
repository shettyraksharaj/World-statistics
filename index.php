<?php
require 'database.php';
if(isset($_POST['id'])){
  header('location:displaydata.php?name='.urldecode($_POST['id']));
  return;
}

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
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>World statistics</title>
  <?php require 'iniconfig.php'; ?>
</head>

<body>
  <video src="bckvid.mp4 " class="position-fixed bckimg view1" autoplay="autoplay" loop="loop">
  </video>
  <div class="container mt-5 view1 vari" value='1'>
    <div class="row align-items-start">
      <h1 class="col display-1 text-center text-white font-weight-bold">WORLD STATISTICS</h1>
    </div>
    <div class="row align-items-center moresty">
      <form class="mainform" method="post">
        <div class="form-group dropdown">
          <input class="form-control form-control-lg ser dropdown-toggle" type="text" id="searchbar" name="id" placeholder="Country name..." data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="dropdown-menu" aria-labelledby="searchbar" style="width:100%; margin-top:-1px" id='serresdisplay'>
          </div>
        </div>
      </form>
    </div>
  </div>
  <span class="container position-fixed viewbar ">
    <div id='viewchange' type='button' class="position-relative">
      <pre class="row text-white justify-content-center text-decoration-none mar"><!--add js for exit animation-->
c

h

a

n

g

e


v

i

e

w
</pre>
    </div>
  </span>
  <footer class="fixed-bottom view1">
    <div class="row">
      <a class="mx-auto text-white text-decoration-none" href="wldstatadminlogin.php"> Admin? </a>
    </div>
  </footer>

<div style="position: fixed; width:100%; height:100%; top:0; left:0; z-index:-101; background:#ffffff;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand font-weight-bold" href="index.php">World Statistics</a>
    </nav>
    <div>
    <h2>Country Statistics:</h2>
    <div class="row form-group">
    <div class="col-8 mx-auto">
    <label for="filter">Search:</label>
    <input type="text" class="form-control" id='filter'>
    </div>
    </div>
    <!--******************************__table navbar__************************************-->
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item ml-auto" role="presentation">
        <a class="nav-link active" href="#population" id="population-tab" data-toggle="tab" role="tab" aria-controls="population" aria-selected="false"><span class="text-dark font-weight-bold">Population</span></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#economy" id="economy-tab" data-toggle="tab" role="tab" aria-controls="economy" aria-selected="false"><span class="text-dark font-weight-bold">Economy</span></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#enviroment" id="enviroment-tab" data-toggle="tab" role="tab" aria-controls="enviroment" aria-selected="false"><span class="text-dark font-weight-bold">Environment</span></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#military" id="military-tab" data-toggle="tab" role="tab" aria-controls="military" aria-selected="false"><span class="text-dark font-weight-bold">Military</span></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#crime" id="crime-tab" data-toggle="tab" role="tab" aria-controls="crime" aria-selected="false"><span class="text-dark font-weight-bold">Crime</span></a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" href="#contribution" id="contribution-tab" data-toggle="tab" role="tab" aria-controls="contribution" aria-selected="false"><span class="text-dark font-weight-bold">Contribution To Technology</span></a>
      </li>
      <li class="nav-item mr-auto" role="presentation">
        <a class="nav-link" href="#eduhealth" id="eduhealth-tab" data-toggle="tab" role="tab" aria-controls="eduhealth" aria-selected="false"><span class="text-dark font-weight-bold">Education and Health</span></a>
      </li>
    </ul>
    <!--________________________________tab content for table__________________________________-->
    <div class="tab-content">
      <!--_____________________________population________________________________-->
      <div class="tab-pane fad show container active" id="population" role="tabpanel" aria-labelledby="population-tab"> 
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>Flag</th>
              <th>Population(bill)</th>
              <th>Birth Rate(%)</th>
              <th>Death Rate(%)</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td style='width:12%;'><img style='width:45%;' src='".$rows[$i]['FLAG']."'></td><td>".$rows[$i]['POPULATION']."</td><td>".$rows[$i]['BIRTH_RATE']."</td><td>".$rows[$i]['DEATH_RATE']."</td></tr>";
              }
            }

            ?>
          </tbody>
        </table>
      </div>
      <!--_____________________________economy________________________________-->
      <div class="tab-pane fade container" id="economy" role="tabpanel" aria-labeledby="economy-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>GDP($tri)</th>
              <th>Percapita($) </th>
              <th>Poverty Percentage(%)</th>
              <th>Currency</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['GDP']."</td><td>".$rows[$i]['PERCAPITA']."</td><td>".$rows[$i]['POVERTY_PER']."</td><td>".$rows[$i]['CURRENCY']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--______________________________enviroment___________________________________-->
      <div class="tab-pane fade container" id="enviroment" role="tabpanel" aria-labelledby="enviroment-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>EPI Score</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['EPI_INDEX']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!---_________________________________military___________________________________-->
      <div class="tab-pane fade container" id="military" role="tabpanel" aria-labelledby="military-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>Budget($bil)</th>
              <th>Personnel(mil)</th>
              <th>Nuclear Warhead</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['BUDGET']."</td><td>".$rows[$i]['PERSONNEL']."</td><td>".$rows[$i]['NUCLEAR_WARHEAD']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--___________________________________crime_________________________________-->
      <div class="tab-pane fade container" id="crime" role="tabpanel" aria-labelledby="crime-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>Crime Rate(%)</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['CRIME_RATE']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--________________________________________techonology_______________________________-->
      <div class="tab-pane fade container" id="contribution" role="tabpanel" aria-labelledby="contribution-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>Cited Document</th>
              <th>Citable Document</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['CITED_DOC']."</td><td>".$rows[$i]['CITABLE_DOC']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
      <!--__________________________________education and health______________________________-->
      <div class="tab-pane fade container" id="eduhealth" role="tabpanel" aria-labelledby="eduhealth-tab">
      <table class="table table-hover">
          <thead>
            <tr>
              <th>Country</th>
              <th>Health Index</th>
              <th>Literacy Rate(%)</th>
              <th>Life Expectancy</th>
              <th>Education Budget($bil)</th>
            </tr>
          </thead>
          <tbody>
            <?php
             if (!empty($rows)) {
              for($i=0; $i < $rowcount; $i++){
                echo "<tr class='ro-con-".$i."'><td class='con-".$i."'>".$rows[$i]['COUNTRY_NAME']."</td><td>".$rows[$i]['HEALTH_INDEX']."</td><td>".$rows[$i]['LITERACY_RATE']."</td><td>".$rows[$i]['LIFE_EXPECTANCY']."</td><td>".$rows[$i]['EDU_BUDGET']."</td></tr>";
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
</div>




  <script>
    $(document).ready(function() {
      $.post('getdata.php', function(data) {
        var jdata = JSON.parse(data);
        var count = jdata.length;
        console.log(jdata);
        $('#searchbar').keyup(function() {
          $('.dropdown-item').remove();
          var linkno = 0;
          var regex = new RegExp($('#searchbar').val(),'i');
          for (var i = 0; i < count; i++) {
            if(linkno>7){
              continue;
            }else{
              linkno++;
            }
            if (regex.test(jdata[i].COUNTRY_NAME)) {
              $('#serresdisplay').append('<a class="dropdown-item" id="'+jdata[i].COUNTRY_NAME+'" href="displaydata.php?id='+ jdata[i].CON_ID+'">'+jdata[i].COUNTRY_NAME+'</a>')
            }else{
            }
          }
        })
      });
    });


    $('#filter').keyup(function(event){
    var filter = $('#filter').val();
    var regx = new RegExp(filter);
    var rows = $('table>tbody>tr>td:first-child').get();
    var nor = rows.length / 7;
    for(var i=0; i<nor ; i++){
      var name = $(rows[i]).html();
      var no = '.ro-con-'+i;
      if(!regx.test(name)){
        $(no).attr('style','display:none');
      }else{
        $(no).attr('style','');
      }
    }
  });

  $('#viewchange').click(function(){
    if(1 == $('.vari').val()){
      console.log('yes');
    $(".view1").attr('style','display:none');
    $('.vari').val(0);
  }else{
    $(".view1").attr('style','');
    $('.vari').val(1);
  }
  })

  </script>
</body>

</html>