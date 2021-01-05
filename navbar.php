<?php
if($_SESSION['propho']== 'admin_photos/profile-user.svg'){
  $proimg = '<a style="margin:  0px 0px -10px 15px ;text-decoration:none" href="#" class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><p style="Color:#ffffff; font-weight:500; display:inline-block" id="prname">'. $_SESSION['name'].'</p>   <img class="rounded-circle" src="'. $_SESSION['propho'].'" style=" margin-top: 3px; margin-right: 1px; display:inline-block; width:45%; height:80%;"></a>';
}else{
  $proimg = '<a style="margin:  0px 0px -10px 15px ;text-decoration:none" href="#" class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><p style="Color:#ffffff; font-weight:500; display:inline-block" id="prname">'. $_SESSION['name'].'</p>   <img class="rounded-circle" src="'. $_SESSION['propho'].'" style=" margin-top: 3px; margin-right: -38px; display:inline-block; width:45%; height:80%;"></a>';
}


?>



<!--HTML for navbar-->
<nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand">Admin Panel</a>
      <ul class="nav nav-pills ml-3 mr-auto">
        <li class="nav-item mx-1">
          <a class="nav-link" href="admindataview.php">View Table</a>
        </li>
        <li class="nav-item dropdown mx-1 ">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#" aria-haspopup="true" aria-expanded="false">Insert and Purge</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="admineditsingle.php"><i class="mr-3 fas fa-plus-square"></i>Data Entry</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item " href="admineditmulti.php"><i class="mr-3 fas fa-skull"></i>Purge Data</a>
          </div>
        </li>
        <li class="nav-item mx-1">
          <a class="nav-link" href="adduser.php">Add Admin</a>
        </li>
      </ul>
      <ul class="nav nav-pills float-left">
      <li style="border-left: 1px solid #000000; " class="dropdown" >
         <?= $proimg ?>
         <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="left:-5%; top:120%" >
            <a href="admin.php" class="dropdown-item"><i class="mr-3 fas fa-user"></i>Account</a>
            <div class="dropdown-divider"></div>
            <a  href="logout.php" class="dropdown-item"><i class="mr-3 fas fa-sign-out-alt"></i>Logout</a>
       </div>
        </li>
      </ul>
    </nav>