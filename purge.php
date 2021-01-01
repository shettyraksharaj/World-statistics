<?php
require 'database.php';//add file to connect to database
/*-------SQL query to delete row from country---------*/
$sql = 'DELETE  FROM COUNTRY';
$STMT = $data->prepare($sql);
$STMT->execute();
?>
