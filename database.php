<?php
try{
    $data =new PDO("mysql:host=localhost;dbname=worldstats",'MrFluffy');//connection to the database
}catch(Exception $e){//exception handling
    echo 'Database connection error :'.$e->getMessage();
}
$data->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>