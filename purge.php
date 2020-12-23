<?php
require 'database.php';

$sql = 'DELETE  FROM COUNTRY';
$STMT = $data->prepare($sql);
$STMT->execute();
?>
