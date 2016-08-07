<?php 

session_start();
include("connection.php");

$user = $_SESSION['id'];

if(strlen($user) > 0) {

$sql = "SELECT * FROM `categories` WHERE (`user_id` = '0' OR `user_id` = '".mysqli_real_escape_string($link, $user)."') AND `hidden` = '0' ORDER BY `order`" ;
      $result = mysqli_query($link, $sql);
	   while ($row = mysqli_fetch_array($result)){
	   if ($row){
	   	$id = $row['category_id'];
     	 	$name = $row['name'];
			echo nl2br('<option value="' . $id . '">' . $name . '</option>');
		} else {
		echo nl2br("\r\n" . "No accounts retrieved");
		}
		}
		
		echo nl2br('<option value="newCategory" data-toggle="modal" data-target="#categoryModal">Add New Category</option>');
} else {
	echo nl2br('<option value="logOut" action="php/sign_in.php?logout=1" >Log Out</option>');
	header("Location: ". $login);

}
?>