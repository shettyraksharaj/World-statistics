<?php
    $data =new PDO("mysql:host=localhost;dbname=worldstats",'MrFluffy');
    $data->setattribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>