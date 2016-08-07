<?php 

session_start();
include("connection.php");

$user = $_SESSION['id'];

if(strlen($user) > 0) {

$sql = "SELECT * FROM `accounts` WHERE `user_id` = '".mysqli_real_escape_string($link, $user)."'" ;
      $result = mysqli_query($link, $sql);
	   while ($row = mysqli_fetch_array($result)){
	   if ($row){
	   	$id = $row['account_id'];
     	 	$name = $row['account_name'];
			echo nl2br('<option value="' . $id . '">' . $name . '</option>');
		} else {
		echo nl2br("\r\n" . "No accounts retrieved");
		}
		}
		
		echo nl2br('<option value="newAccount" data-toggle="modal" data-target="#myModal">Add New Account</option>');
} else {
	//echo nl2br('<option value="logOut" action="php/sign_in.php?logout=1" >Log Out</option>');
	//header("Location: ". $login);

}
?>