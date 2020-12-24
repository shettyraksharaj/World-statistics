<?php
session_start();
if (!isset($_SESSION['admin'])) {
  die('Access Denied');
}

if(isset($_POST['cancel'])){
  header('location:admindataview.php');
  return;
}

require 'database.php';
$valsql = 'SELECT * FROM COUNTRY JOIN CRIME JOIN ECONOMY JOIN EDU_AND_HEALTH JOIN ENVIROMENT JOIN MILITARY JOIN POPULATION JOIN TECHNOLOGY WHERE COUNTRY.CON_ID = CRIME.CON_ID AND COUNTRY.CON_ID = ECONOMY.CON_ID AND COUNTRY.CON_ID = EDU_AND_HEALTH.CON_ID AND COUNTRY.CON_ID = ENVIROMENT.CON_ID AND COUNTRY.CON_ID = MILITARY.CON_ID AND COUNTRY.CON_ID = POPULATION.CON_ID AND COUNTRY.CON_ID = TECHNOLOGY.CON_ID AND COUNTRY.CON_ID = :id';
$fieldata = $data->prepare($valsql);
$fieldata->execute(array(':id'=>$_GET['id']));
$rows;
if($row = $fieldata->fetch(PDO::FETCH_ASSOC)){
  $index = array_keys($row);
    foreach($index as $y){
      $row[$y] = htmlentities($row[$y]);
    }
}else{
  echo 'Bad Data';
  return;
}

if (isset($_POST['update'])) {

  if (isset($_FILES['flag'])&& $_FILES['flag']['name']!='') {
    $flagname = $_FILES["flag"]['name'];
    $flaginiloc = $_FILES["flag"]['tmp_name'];
    $flagsize = $_FILES["flag"]['size'];
    $flaguperr = $_FILES["flag"]['error'];
    $exp = explode(".",$flagname);
    $imgext = end($exp);
    $imgNloc = $row['FLAG'];
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
      $imgNloc = $row['FLAG'];
      echo $imgNloc;
  }
  $sql = $data->prepare('UPDATE country JOIN crime JOIN economy JOIN edu_and_health join enviroment JOIN military JOIN population JOIN technology SET country.COUNTRY_NAME = :CON_NAM,country.FLAG =:FLAG ,population.POPULATION =:pop ,population.BIRTH_RATE =:b_rt,population.DEATH_RATE =:d_rt, economy.GDP =:gdp, economy.PERCAPITA =:pcap ,economy.POVERTY_PER =:pov ,economy.CURRENCY =:cur,enviroment.EPI_INDEX =:e_ix,military.BUDGET =:bdg,military.PERSONNEL =:pernl,military.NUCLEAR_WARHEAD =:nuke, crime.CRIME_RATE =:c_rt,technology.CITED_DOC =:ci_doc,technology.CITABLE_DOC =:cibl_doc,edu_and_health.HEALTH_INDEX =:h_ix,edu_and_health.LITERACY_RATE =:l_rt,edu_and_health.LIFE_EXPECTANCY =:l_ex,edu_and_health.EDU_BUDGET =:edu_bg WHERE country.CON_ID = :id AND country.CON_ID = crime.CON_ID AND country.CON_ID = economy.CON_ID AND country.CON_ID = edu_and_health.CON_ID AND country.CON_ID = enviroment.CON_ID AND country.CON_ID = population.CON_ID AND country.CON_ID = technology.CON_ID');
  $sql->execute(array(
                ':CON_NAM'=>$_POST["country_name"],
                ':FLAG'=>$imgNloc,
                ':pop' => $_POST['population'] == "" ? NULL : $_POST['population'],
                ':b_rt' => $_POST['birth_rt'] == "" ? NULL : $_POST['birth_rt'] ,
                ':d_rt' => $_POST['death_rt'] == "" ? NULL : $_POST['death_rt'],
                ':c_rt' => $_POST['crime_rt'] == "" ? NULL : $_POST['crime_rt'],
                ':gdp' => $_POST['gdp'] == "" ? NULL : $_POST['gdp'],
                ':pcap' => $_POST['percap'] == "" ? NULL : $_POST['percap'],
                ':pov' => $_POST['povper'] == "" ? NULL : $_POST['povper'],
                ':cur' => $_POST['cur'],
                ':h_ix'=>$_POST['h_index'] == "" ? NULL : $_POST['h_index'],
                ':l_rt'=>$_POST['lit_rt'] == "" ? NULL : $_POST['lit_rt'],
                ':l_ex'=>$_POST['l_exp'] == "" ? NULL : $_POST['l_exp'],
                ':edu_bg'=>$_POST['e_budget'] == "" ? NULL : $_POST['e_budget'],
                ':e_ix'=>$_POST['epi'] == "" ? NULL : $_POST['epi'],
                ':bdg'=>$_POST['m_budget'] == "" ? NULL : $_POST['m_budget'],
                ':pernl'=>$_POST['personnel'] == "" ? NULL : $_POST['personnel'],
                ':nuke'=>$_POST['nuke'] == "" ? NULL : $_POST['nuke'],
                ':ci_doc'=>$_POST['c_doc'] == "" ? NULL : $_POST['c_doc'],
                ':cibl_doc'=>$_POST['cb_doc'] == "" ? NULL : $_POST['cb_doc'],
                ':id'=>$_GET['id']));
  header('location:admindataview.php');
  return;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>update</title>
  <?php require 'iniconfig.php' ?>
</head>

<body>
  <div class="container">
    <br>
    <br>
  <h2>Update Values:</h2>
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item ml-auto" role="presentation">
      <a class="nav-link active" href="#insert-counpopeoc" id="insert-counpopeoc-tab" data-toggle="tab" role="tab" aria-controls="insert-counpopeoc" aria-selected="true">Country, Population and Economy</a>
    </li>
    <li class="nav-item" role="presentation">
      <a class="nav-link" href="#insert-envmilcri" id="insert-envmilcri-tab" data-toggle="tab" role="tab" aria-controls="insert-envmilcri" aria-selected="false">Enviroment, Military and Crime</a>
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
        <div class="form-group my-4 row">
          <label for="country_name">Country Name:</label>
          <div class="col-6">
            <input class="form-control" type="text" name="country_name" placeholder="India" id="country_name" value="<?= $row['COUNTRY_NAME'] ?>" >
            <div class="invalid-feedback">
              Field cannot be empty.
            </div>
          </div>
          <label for="cur">Currency: </label>
          <div class="col-4">
            <input class="form-control" type="text" name="cur" id="cur" value="<?= $row['CURRENCY'] ?>">
            <div class="invalid-feedback">
              Field cannot be empty.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row">
          <label for="population">Population: </label>
          <div class="col-4">
            <input class="form-control num" type="text" name="population" id="population" value="<?= $row['POPULATION'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="birth_rt">Birth Rate: </label>
          <div class="col-2">
            <input class="form-control num" type="text" name="birth_rt" id="birth_rt" value="<?= $row['BIRTH_RATE'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="death_rt">Death Rate: </label>
          <div class="col-2">
            <input class="form-control num" type="text" name="death_rt" id="death_rt" value="<?= $row['DEATH_RATE'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row">
          <label for="gdp">GDP: </label>
          <div class="col-4">
            <input class="form-control num" type="text" name="gdp" id="gdp" value="<?= $row['GDP'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="percap">Percapita: </label>
          <div class="col-2">
            <input class="form-control num" type="text" name="percap" id="percap" value="<?= $row['PERCAPITA'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="povper">Poverty Percentage: </label>
          <div class="col-2">
            <input class="form-control num" type="text" name="povper" id="povper" value="<?= $row['POVERTY_PER'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row">
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
          <div class="col-2">
          <img style="width:50%;" src="<?= $row['FLAG'] ?>" id="imgPreview">
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
            <input class="form-control num" type="text" name="epi" id="epi" value="<?= $row['EPI_INDEX'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="m_budget">Military Budget: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="m_budget" id="m_budget" value="<?= $row['BUDGET'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="personnel">Personnel: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="personnel" id="personnel" value="<?= $row['PERSONNEL'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row ">
          <label for="nuke">Nuclear Warheads: </label>
          <div class="col-5">
            <input class="form-control num" type="text" name="nuke" id="nuke" value="<?= $row['NUCLEAR_WARHEAD'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="crime_rt">Crime Rate: </label>
          <div class="col-4">
            <input class="form-control num" type="text" name="crime_rt" id="crime_rt" value="<?= $row['CRIME_RATE'] ?>">
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
            <input class="form-control num" type="text" name="c_doc" id="c_doc" value="<?= $row['CITED_DOC'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="cb_doc">Citable Documnets: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="cb_doc" id="cb_doc" value="<?= $row['CITABLE_DOC'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row">
          <label for="h_index">Health Index: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="h_index" id="h_index" value="<?= $row['HEALTH_INDEX'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="lit_rt">Literacy Rate: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="lit_rt" id="lit_rt" value="<?= $row['LITERACY_RATE'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
        <div class="form-group my-4 row">
          <label for="l_exp">Life Expectancy: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="l_exp" id="l_exp" value="<?= $row['LIFE_EXPECTANCY'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
          <label for="e_budget">Education Budget: </label>
          <div class="col-3">
            <input class="form-control num" type="text" name="e_budget" id="e_budget" value="<?= $row['EDU_BUDGET'] ?>">
            <div class="invalid-feedback">
              Not a number.
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="mx-auto position-absolute submitbtn">
        <button class="btn btn-primary" id="update">Update</button>
        <button class="btn btn-danger" type="submit" name="cancel" value="cancel" id="cancel">Cancel</button>
      </div>
    </div>
  <div style='display:none;' id='alertwindow'>
            <div id='alertboxx'>
              <p>Previous values will be replaced with new ones.<br> Do you wish to proceed.</p>
              <div class="row">
                <button class='btn btn-primary mx-auto' name="update" value="update" type="submit" id='confirm'>Yes</button>
                <button class='btn btn-danger mx-auto' id='cancel'>Cancel</button>
              </div>
            </div>
          </div>
          </form>
          </div>
  <!--_________________________________tab-content end for insert module_________________________________________-->
  <script>
     $('#update').click(function(event){
       event.preventDefault();
        $("#alertwindow").fadeIn(500);
      });
      $('#cancel').click(function(){
        $('#alertwindow').attr('style','display:none;');
      });
      $('#confirm').click(function(){
        $('#alertwindow').attr('style','display:none;');
      });


            $(document).ready(()=>{ 
          $('#flag').change(function(){ 
            const file = this.files[0]; 
            console.log(file); 
            if (file){ 
              let reader = new FileReader(); 
              reader.onload = function(event){ 
                console.log(event.target.result); 
                $('#imgPreview').attr('src', event.target.result); 
              } 
              reader.readAsDataURL(file); 
            } 
          }); 
        });


    $("#insert").click(function(event) {
      var regex = /^[0-9]*$/;
      var numeleid = ['#population', '#death_rt', '#percap', '#epi', '#personnel', '#crime_rt', '#cb_doc', '#lit_rt', '#e_budget', '#birth_rt', '#povper', '#nuke', '#h_index', '#gdp', '#c_doc', '#m_budget', "#l_exp"];
      if ($("#country_name").val() == "") {
        event.preventDefault();
        $("#country_name").attr("class", "form-control  is-invalid");
      } else {
        $("#country_name").attr("class", "form-control  is-valid");
      }
      if ($("#cur").val() == "") {
        event.preventDefault();
        $("#cur").attr("class", "form-control  is-invalid");
      } else {
        $("#cur").attr("class", "form-control  is-valid");
      }
      "cur"
      for (var i = 0; i < numeleid.length; i++) {
        $
        if (regex.test($(numeleid[i]).val())) {
          $(numeleid[i]).attr("class", "form-control  is-valid");
        } else {
          event.preventDefault();
          $(numeleid[i]).attr("class", "form-control  is-invalid");
        }
      }
    });
  </script>
  <!--________________________end of tab content for update module________________________-->
  <!--/////////////////////////////___end of update module_\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->

</body>
</html>