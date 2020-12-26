<?php
require 'database.php';
$sql = 'SELECT * FROM COUNTRY JOIN CRIME JOIN ECONOMY JOIN EDU_AND_HEALTH JOIN ENVIROMENT JOIN MILITARY JOIN POPULATION JOIN TECHNOLOGY WHERE COUNTRY.CON_ID = CRIME.CON_ID AND COUNTRY.CON_ID = ECONOMY.CON_ID AND COUNTRY.CON_ID = EDU_AND_HEALTH.CON_ID AND COUNTRY.CON_ID = ENVIROMENT.CON_ID AND COUNTRY.CON_ID = MILITARY.CON_ID AND COUNTRY.CON_ID = POPULATION.CON_ID AND COUNTRY.CON_ID = TECHNOLOGY.CON_ID AND COUNTRY.CON_ID = :id';
$displaydata = $data->prepare($sql);
$displaydata->execute(array(':id' => $_GET['id']));
$rows = $displaydata->fetch(PDO::FETCH_ASSOC);
$index = array_keys($rows);
foreach ($index as $y) {
    $rows[$y] = $rows[$y] ? $rows[$y] : '-';
    $rows[$y] = htmlentities($rows[$y]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php require 'iniconfig.php'; ?>
</head>

<body style='background: #F0F1F0;'>


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="nav nav-pills float-right mr-5">
            <a href="index.php"><button class='btn btn-dark'><i class="fas fa-arrow-left"></i> Back</button></a>
        </ul>
        <a class="navbar-brand font-weight-bold" href="index.php">World Statistics</a>
    </nav>
    <h1 class="ml-3">Stats of <?= $rows['COUNTRY_NAME'] ?></h1>
    <div class="container">
        <div class="row mt-3">
            <div class="col-4" style='background:#ffffff;'>
                <div class="row">
                    <h5 class='ml-2 mt-1'>Population:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-users mt-1"></i>
                    <p class="col-10">Total Poulation: <?= $rows['POPULATION'] ?>$ Billion.</p>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-birthday-cake mt-1"></i>
                    <p class="col-10">Birth Rate: <?= $rows['BIRTH_RATE'] ?>%. <span style="font-size:70%;">(per 1000 persons)</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-skull-crossbones mt-1"></i>
                    <p class="col-10">Death Rate: <?= $rows['DEATH_RATE'] ?>%. <span style="font-size:70%;">(per 1000 persons)</span> </p>
                </div>
            </div>


            <div class="col-4" style='background:#ffffff;'>
                <div class='row'>
                    <h5 class='ml-2 mt-1'>Economy:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-dollar-sign mt-1"></i>
                    <p class="col-10">GDP: <?= $rows['GDP'] ?>$ Trillion.</p>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-hand-holding-usd mt-1"></i>
                    <p class="col-10">Per-capita: <?= $rows['PERCAPITA'] ?>$.</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-arrow-down mt-1"></i>
                    <p class="col-10">Poverty Percentage: <?= $rows['POVERTY_PER'] ?>%.</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-money-bill-alt mt-1"></i>
                    <p class="col-10">Currency: <?= $rows['CURRENCY'] ?>.</p>
                </div>
            </div>
            
            
            <div class="col-4" style='background:#ffffff; '>
            <img class="img-thumbnail mt-2 ml-3" src="<?= $rows['FLAG'] ?>" style="width:80%">
            </div>


            </div>
            <div class="row">

            <div class="col-4" style='background:#ffffff;'>
                <div class='row'>
                    <h5 class='ml-2 mt-1'>Crime:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-balance-scale-right mt-1"></i>
                    <p class="col-10">Crime Rate: <?= $rows['CRIME_RATE'] ?>%.<span style="font-size:70%;">(per 100k persons)</p>
                </div>
            </div>


            <div class="col-4" style='background:#ffffff;'>
                <div class='row'>
                    <h5 class='ml-2 mt-1'>Technology and Research:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-file-alt mt-1"></i>
                    <p class="col-10">Cited Document: <?= $rows['CITED_DOC'] ?>.</p>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-file-alt mt-1"></i>
                    <p class="col-10">Citeble Document: <?= $rows['CITABLE_DOC'] ?>.</p>
                </div>
            </div>



            <div class="col-4" style='background:#ffffff;'>
                <div class='row'>
                    <h5 class='ml-2 mt-1'>Education and Health:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-plus mt-1"></i>
                    <p class="col-10">Health Index: <?= $rows['HEALTH_INDEX'] ?>.</p>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-graduation-cap mt-1"></i>
                    <p class="col-10">Literacy Rate: <?= $rows['LITERACY_RATE'] ?>%.</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-heartbeat mt-1"></i>
                    <p class="col-10">Life Expectancy: <?= $rows['LIFE_EXPECTANCY'] ?> years.</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-coins mt-1"></i>
                    <p class="col-10">Education Budget: <?= $rows['EDU_BUDGET'] ?>$ Billion.</p>
                </div>
            </div>

            </div>
            <div class="row">

            <div class="col-4" style='background:#ffffff;'>
                <div class="row">
                    <h5 class='ml-2 mt-1'>Environment:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-tree mt-1"></i>
                    <p class="col-10">EPI Score: <?= $rows['EPI_INDEX'] ?>.</p>
                </div>
            </div>



            <div class="col-4" style='background:#ffffff;'>
                <div class='row'>
                    <h5 class='ml-2 mt-1'>Military:</h5>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-shield-alt mt-1"></i>
                    <p class="col-10">Miltiary Budget: <?= $rows['BUDGET'] ?>$ Billion.</p>
                </div>
                <div class="row mx-auto">
                    <i class="col-1 fas fa-user-shield mt-1"></i>
                    <p class="col-10">Personnel: <?= $rows['PERSONNEL'] ?> million.</p>
                </div>
                <div class="row mx-auto">
                    <i class=" col-1 fas fa-radiation mt-1"></i>
                    <p class="col-10">Nuclear Warheads: <?= $rows['NUCLEAR_WARHEAD'] ?>.</p>
                </div>
            </div>

            <div class="col-4" style='background:#ffffff;'>
                <h5 class='ml-2 mt-1'>Charts:</h5>
                <p>Poverty Percentage:</p>
                <div class="progress" style="height: 20px;">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: <?= $rows['POVERTY_PER'] ?>%;" aria-valuenow="<?= $rows['POVERTY_PER'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p>Literacy Rate:</p>
                <div class="progress mb-3" style="height: 20px;">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: <?= $rows['LITERACY_RATE'] ?>%;" aria-valuenow="<?= $rows['LITERACY_RATE'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>