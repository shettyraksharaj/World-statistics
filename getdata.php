<?php
require 'database.php';

$sql = 'SELECT * FROM COUNTRY';
$country = $data->prepare($sql);
$country->execute();
$countrydata = $country->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($countrydata);

?>