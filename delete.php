<?
session_start();
require 'database.php';

if(isset($_POST['cancel'])){
    header('location:admindataview.php');
    return;
}

$valsql = 'SELECT * FROM COUNTRY JOIN CRIME JOIN ECONOMY JOIN EDU_AND_HEALTH JOIN ENVIROMENT JOIN MILITARY JOIN POPULATION JOIN TECHNOLOGY WHERE COUNTRY.CON_ID = CRIME.CON_ID AND COUNTRY.CON_ID = ECONOMY.CON_ID AND COUNTRY.CON_ID = EDU_AND_HEALTH.CON_ID AND COUNTRY.CON_ID = ENVIROMENT.CON_ID AND COUNTRY.CON_ID = MILITARY.CON_ID AND COUNTRY.CON_ID = POPULATION.CON_ID AND COUNTRY.CON_ID = TECHNOLOGY.CON_ID AND COUNTRY.CON_ID = :id';
$fieldata = $data->prepare($valsql);
$fieldata->execute(array(':id'=>$_GET['id']));
$rows;
if($row = $fieldata->fetch(PDO::FETCH_ASSOC)){
  $index = array_keys($row);
    foreach($index as $y){
        $row[$y] = $row[$y] != ''? $row[$y] : '-';
        $row[$y] = htmlentities($row[$y]);
    }
}else{
  echo 'Bad Data';
  return;
}


if (isset($_POST['delete'])) {
    $delsql = 'DELETE FROM COUNTRY WHERE CON_ID = :id';
    $deldata = $data->prepare($delsql);
    $deldata->execute(array(':id'=>$_GET['id']));
    header('location:admindataview.php');
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require 'iniconfig.php';?>
</head>
<body>
    <div class="container mt-4">
        <h2>Delete Values:</h2>
        <div class="row mt-4">
            <div class="col-6">
                <h4>values to be deleted:</h4>
                <div class="ml-5 mt-3">
                <table>
                    <thead>
                        <tr>
                            <th class="font-weight-bold">Fields</th>
                            <th class="font-weight-bold">Values</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        foreach($index as $y){
                            if ($y == 'CON_ID') {
                                continue;
                            }elseif($y == 'FLAG'){
                                echo "<tr><td style = 'width:55%'>".$y.":</td><td><img src='".$row[$y]."' style='width:30%;'></td></tr>";
                            }else{
                                echo "<tr><td style = 'width:55%'>".$y.":</td><td>".$row[$y]."</td></tr>";
                            }
                        }
                    ?>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="col-5 position-fixed" style="top:40%; right:10%">
            <form method='post'>
            <button class="btn btn-primary"  style="width:100%;" id="deletebutton">Delete</button>
                    <br>
                    <br>
                    <button class="btn btn-danger" type="submit" name='cancel' style="width:100%;">Cancel</button>
            </form>
            </div>
        </div>
    </div>
    <div style='display:none; background:rgba(0,0,0,0.8);' id='alertwindow'>
            <div id='alertboxi'>
            <i class="fas fa-exclamation-triangle"></i>
              <p>Clicking on Yes will empty the Database are you sure.</p>
              <form method='post'>
              <div class="row">
                <button class='btn btn-primary mx-auto' type="submit" name='delete' id='confirm'>Yes</button>
                <button class='btn btn-danger mx-auto' id='cancel'>Cancel</button>
              </div>
              </form>
            </div>
          </div>
    <script>
      $('#deletebutton').click(function(event){
          event.preventDefault();
        $("#alertwindow").fadeIn(500);
      });
      $('#cancel').click(function(){
        $('#alertwindow').attr('style','display:none;');
      });
      $('#confirm').click(function(){
        $('#alertwindow').attr('style','display:none;');
      });
    </script>
</body>
</html>