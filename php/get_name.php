<?php 
session_start();
include("connection.php");
$user = $_SESSION['id'];
$sql = "SELECT `name` FROM `users` WHERE `user_id` = '".mysqli_real_escape_string($link, $user)."' LIMIT 1";
$result = mysqli_query($link, $sql); 

$row = mysqli_fetch_array($result);
$name = $row['name'];
 echo trim(json_encode($name), '"'); // write it to the output
 
mysqli_close($link); 

?>
