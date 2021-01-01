<?php
require 'database.php';//add file to connect to database
/*-------SQL query to fetch country data from database-------*/
$sql = 'SELECT * FROM COUNTRY';
$country = $data->prepare($sql);
$country->execute();
$countrydata = $country->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($countrydata);//encode data into JSON format

?>