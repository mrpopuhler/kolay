<?php
  $link = mysqli_connect("localhost","web208-kolaydb","db4xiphoid2","web208-kolaydb");  
  if (mysqli_connect_error()) {
    die("Could not connect to the database");
  }
  
  $login = "http://kolayaccounts.com/index.html";
  $login_array = array("http://kolayaccounts.com/index.html","http://www.kolayaccounts.com/index.html","http://kolayaccounts.com","http://www.kolayaccounts.com","http://kolayaccounts.com/","http://www.kolayaccounts.com/");
  $mainpage = "http://kolayaccounts.com/checkbook.html";
  $startpage = "http://kolayaccounts.com/start.html";
  $domain = "kolayaccounts.com";
  $domain_array = array("kolayaccounts.com", "www.kolayaccounts.com");
  $badlogin = "http://". $domain ."/BadLogin.html";
  $existing_user = "http://". $domain . "/ExistingUser.html";
?>