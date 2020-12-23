<?php
session_start();
if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}
  $data =new PDO("mysql:host=localhost;dbname=worldstats",'MrFluffy');
  $data->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  if (isset($_POST['Submit'])) {
    if (isset($_FILES['flag'])&& $_FILES['flag']['name']!='') {
      $flagname = $_FILES["flag"]['name'];
      $flaginiloc = $_FILES["flag"]['tmp_name'];
      $flagsize = $_FILES["flag"]['size'];
      $flaguperr = $_FILES["flag"]['error'];
      $exp = explode(".",$flagname);
      $imgext = end($exp);
      $imgNloc = "flags"."/".time().".".$imgext;
    if ($flaguperr == 0) {
      if ($flagsize<1024000) {
        if ($imgext == "svg") {
          if (move_uploaded_file($flaginiloc,$imgNloc)) {
          }else {
            $_SESSION['error'] = "Error: Unable to upload";
            header("location:admineditsingle.php");
            return;
          }
        }else {
          $_SESSION['error'] = "Invalid Format only svg(Scalable Vector Graphics) allowed";
          header("location:admineditsingle.php");
          return;
        }
      }else {
        $_SESSION['error'] = "Image size too large";
        header("location:admineditsingle.php");
        return;
      }
    }else {
      $_SESSION['error'] = "Error:Unable to upload";
      header("location:admineditsingle.php");
      return;
    }
    }else{
        $imgNloc = "flags/flags.svg";
    }
      $sql = $data->prepare('INSERT INTO COUNTRY (COUNTRY_NAME,FLAG) VALUES (:CON_NAM,:FLAG)');
      $sql->execute(array(
                    ':CON_NAM'=>$_POST["country_name"],
                    ':FLAG'=>$imgNloc));
      $cid = $data->lastInsertId('con_id');
      echo $cid;
      $sql = $data->prepare('INSERT INTO POPULATION (CON_ID,POPULATION,BIRTH_RATE,DEATH_RATE) VALUES (:cid,:pop,:b_rt,:d_rt)');
      $sql->execute(array(
                          ':cid' => $cid,
                          ':pop' => $_POST['population'] == "" ? NULL : $_POST['population'],
                          ':b_rt' => $_POST['birth_rt'] == "" ? NULL : $_POST['birth_rt'] ,
                          ':d_rt' => $_POST['death_rt'] == "" ? NULL : $_POST['death_rt']));
      $sql = $data->prepare('INSERT INTO CRIME (CON_ID,CRIME_RATE) VALUES (:cid,:c_rt)');
      $sql->execute(array(
                          ':cid' => $cid,
                          ':c_rt' => $_POST['crime_rt'] == "" ? NULL : $_POST['crime_rt']));
      $sql = $data->prepare('INSERT INTO ECONOMY (CON_ID,GDP,PERCAPITA,POVERTY_PER,CURRENCY) VALUES (:cid,:gdp,:pcap,:pov,:cur)');
      $sql->execute(array(
                          ':cid' => $cid,
                          ':gdp' => $_POST['gdp'] == "" ? NULL : $_POST['gdp'],
                          ':pcap' => $_POST['percap'] == "" ? NULL : $_POST['percap'],
                          ':pov' => $_POST['povper'] == "" ? NULL : $_POST['povper'],
                          ':cur' => $_POST['cur']));
      $sql = $data->prepare('INSERT INTO EDU_AND_HEALTH (CON_ID,HEALTH_INDEX,LITERACY_RATE,LIFE_EXPECTANCY,EDU_BUDGET) VALUES (:cid,:h_ix,:l_rt,:l_ex,:edu_bg)');
      $sql->execute(array(
                          ':cid'=>$cid,
                          ':h_ix'=>$_POST['h_index'] == "" ? NULL : $_POST['h_index'],
                          ':l_rt'=>$_POST['lit_rt'] == "" ? NULL : $_POST['lit_rt'],
                          ':l_ex'=>$_POST['l_exp'] == "" ? NULL : $_POST['l_exp'],
                          ':edu_bg'=>$_POST['e_budget'] == "" ? NULL : $_POST['e_budget']));
      $sql = $data->prepare('INSERT INTO ENVIROMENT (CON_ID,EPI_INDEX) VALUES (:cid,:e_ix)');
      $sql->execute(array(
                          ':cid'=>$cid,
                          ':e_ix'=>$_POST['epi'] == "" ? NULL : $_POST['epi']));
      $sql = $data->prepare('INSERT INTO MILITARY (CON_ID,BUDGET,PERSONNEL,NUCLEAR_WARHEAD) VALUES (:cid,:bdg,:pernl,:nuke)');
      $sql->execute(array(
                          ':cid'=>$cid,
                          ':bdg'=>$_POST['m_budget'] == "" ? NULL : $_POST['m_budget'],
                          ':pernl'=>$_POST['personnel'] == "" ? NULL : $_POST['personnel'],
                          ':nuke'=>$_POST['nuke'] == "" ? NULL : $_POST['nuke']));
      $sql = $data->prepare('INSERT INTO TECHNOLOGY (CON_ID,CITED_DOC,CITABLE_DOC) VALUES (:cid,:ci_doc,:cibl_doc)');
      $sql->execute(array(
                          ':cid'=>$cid,
                          ':ci_doc'=>$_POST['c_doc'] == "" ? NULL : $_POST['c_doc'],
                          ':cibl_doc'=>$_POST['cb_doc'] == "" ? NULL : $_POST['cb_doc']));
      header("location:admineditsingle.php");
      return;
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
    <!--+++++++++++++++++++++__first navbar___++++++++++++++++++++++++++-->
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand">DATABASE EDITIOR</a>
      <ul class="nav nav-pills ml-3 mr-auto">
        <li class="nav-item mx-1">
          <a class="nav-link" href="admindataview.php">View Table</a>
        </li>
        <li class="nav-item dropdown mx-1">
          <a class="nav-link dropdown-toggle active" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert</a>
          <div class="dropdown-menu">
            <a class="dropdown-item active" href="admineditsingle.php">single insert</a>
            <a class="dropdown-item" href="admineditmulti.php">batch mode</a>
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
      <!--\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\____insert module____/////////////////////////////////-->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item ml-auto" role="presentation">
            <a class="nav-link active" href="#insert-counpopeoc" id="insert-counpopeoc-tab" data-toggle="tab" role="tab" aria-controls="insert-counpopeoc" aria-selected="true">Country, Population and Economy</a>
          </li>
          <li class="nav-item" role="presentation">
            <a  class="nav-link" href="#insert-envmilcri" id="insert-envmilcri-tab" data-toggle="tab" role="tab" aria-controls="insert-envmilcri" aria-selected="false">Enviroment, Military and Crime</a>
          </li>
          <li class="nav-item mr-auto" role="presentation">
            <a class="nav-link" href="#insert-coneduhealth" id="insert-coneduhealth-tab" data-toggle="tab" role="tab" aria-controls="insert-coneduhealth" aria-selected="false">Contribution To Techonology, Education and Health</a>
          </li>
        </ul>

        <!--______________________________tab content for insert module_______________________________________-->
        <form class="container" method="post" enctype="multipart/form-data">
        <div class="tab-content">

          <!--_____________________________country________________________________-->
          <!--___________________________population_______________________________-->
          <!--_____________________________economy________________________________-->
          <div class="tab-pane fade show active container" id="insert-counpopeoc" role="tabpanel" aria-labelledby="insert-counpopeoc-tab">
              <div class="form-group my-4">
                <label for="country_name">Country Name:</label>
                <div class="col-6">
                  <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name">
                  <div class="invalid-feedback">
                    Field cannot be empty.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row">
                <label for="population">Population: </label>
                <div class="col-4">
                  <input class="form-control num" type="text" name="population" id="population">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="birth_rt">Birth Rate: </label>
                <div class="col-2">
                  <input class="form-control num" type="text" name="birth_rt" id="birth_rt">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="death_rt">Death Rate: </label>
                <div class="col-2">
                  <input class="form-control num" type="text" name="death_rt" id="death_rt">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row">
                <label for="gdp">GDP: </label>
                <div class="col-4">
                  <input class="form-control num" type="text" name="gdp" id="gdp">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="percap">Percapita: </label>
                <div class="col-2">
                  <input class="form-control num" type="text" name="percap" id="percap">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="povper">Poverty Percentage: </label>
                <div class="col-2">
                  <input class="form-control num" type="text" name="povper" id="povper">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row">
                <label for="cur">Currency: </label>
                <div class="col-6">
                  <input class="form-control" type="text" name="cur" id="cur">
                  <div class="invalid-feedback">
                    Field cannot be empty.
                  </div>
                </div>
                <label for="flag">Flag: </label>
                <div class="col-4">
                  <input class="form-control-file col-5" type="file" name="flag" id="flag">
                  <p class="text-danger">
                  <?php
                   if (isset($_SESSION['error'])) {
                     echo $_SESSION['error'];
                     unset($_SESSION['error']);
                   }
                   ?>
              </p>
                </div>
              </div>
          </div>
          <!--____________________________enviroment_______________________________-->
          <!---____________________________military________________________________-->
          <!--______________________________crime__________________________________-->
          <div class="tab-pane fade container" id="insert-envmilcri" role="tabpanel" aria-labelledby="insert-envmilcri-tab">
              <div class="form-group my-4 row">
                <label for="epi">EPI Score: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="epi" id="epi">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="m_budget">Military Budget: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="m_budget" id="m_budget">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="personnel">Personnel: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="personnel" id="personnel">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row ">
                <label for="nuke">Nuclear Warheads: </label>
                <div class="col-5">
                  <input class="form-control num" type="text" name="nuke" id="nuke">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="crime_rt">Crime Rate: </label>
                <div class="col-4">
                  <input class="form-control num" type="text" name="crime_rt" id="crime_rt">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
          </div>
          <!--____________________________techonology_______________________________-->
          <!--_______________________education and health___________________________-->
          <div class="tab-pane fade container" id="insert-coneduhealth" role="tabpanel" aria-labelledby="insert-coneduhealth-tab">
              <div class="form-group my-4 row">
                <label for="c_doc">Cited Documents: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="c_doc" id="c_doc">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="cb_doc">Citable Documnets: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="cb_doc" id="cb_doc">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row">
                <label for="h_index">Health Index: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="h_index" id="h_index">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="lit_rt">Literacy Rate: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="lit_rt" id="lit_rt">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
              <div class="form-group my-4 row">
                <label for="l_exp">Life Expectancy: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="l_exp" id="l_exp">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
                <label for="e_budget">Education Budget: </label>
                <div class="col-3">
                  <input class="form-control num" type="text" name="e_budget" id="e_budget">
                  <div class="invalid-feedback">
                    Not a number.
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="mx-auto position-absolute submitbtn">
            <button class="btn btn-primary" type="submit" name="Submit" value="submit" id="insert">Insert</button>
          </div>
        </div>
      </form>
        <!--_________________________________tab-content end for insert module_________________________________________-->
        <script>
          $("#insert").click(function (event) {
            var regex = /[0-9]/;
            var numeleid = ['#population', '#death_rt', '#percap', '#epi', '#personnel', '#crime_rt', '#cb_doc', '#lit_rt', '#h_budget', '#birth_rt', '#povper', '#nuke', '#h_index', '#gdp', '#c_doc', '#m_budget', "#l_exp"];
            if($("#country_name").val() == ""){
              /*event.preventDefault();*/
              $("#country_name").attr("class","form-control  is-invalid");
            }else{
              $("#country_name").attr("class","form-control  is-valid");
            }
            if($("#cur").val() == ""){
              /*event.preventDefault();*/
              $("#cur").attr("class","form-control  is-invalid");
            }else{
              $("#cur").attr("class","form-control  is-valid");
            }
            "cur"
            for(var i = 0; i< numeleid.length; i++){
              if($(numeleid[i]).val() != ""){
                if(!regex.test($(numeleid[i]).val())){
                  /*event.preventDefault();*/
                  $(numeleid[i]).attr("class","form-control  is-invalid");
                }else{
                  $(numeleid[i]).attr("class","form-control  is-valid");
                }
              }
            }
          });
        </script>
      <!--////////////////////////////____end of insert module_____\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
  </body>
</html>
