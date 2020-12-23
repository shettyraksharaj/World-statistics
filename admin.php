<?php
session_start();
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add User</title>
    <?php require "iniconfig.php" ?>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand">DATABASE EDITIOR</a>
      <ul class="nav nav-pills ml-3 mr-auto">
        <li class="nav-item mx-1">
          <a class="nav-link" href="admindataview.php">View Table</a>
        </li>
        <li class="nav-item dropdown mx-1 ">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admineditsingle.php">single entry</a>
            <a class="dropdown-item " href="admineditmulti.php">batch edit</a>
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
