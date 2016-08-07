<?php 
session_start();

include("connection.php");

$user = $_SESSION['id'];
$new_name = $_POST['new_name'];

$sql = "UPDATE `users` SET `name`='".mysqli_real_escape_string($link, $new_name)."' WHERE `user_id` ='".mysqli_real_escape_string($link, $user)."' ";
$result = mysqli_query($link, $sql);

if ($result){
echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Name updated</strong></div>');


} else {

echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Invalid query: ' . mysqli_error() . '</strong></div>');
echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $sql . '</strong></div>');
}


	 

mysqli_close($link); 

?>

