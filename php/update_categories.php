<?php 
session_start();

include("connection.php");
$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
$user = $_SESSION['id'];
if($_POST['hide']=='1')
{$hide = '1';} else {$hide = '0';}
$cat_id = $_POST['category_id'];
//$order = $_POST['order'];

//updating hiddenness and order - unfinished
		

$sql = "UPDATE `user_categories` SET `hide`='".mysqli_real_escape_string($link, $hide)."' WHERE `user_id` = '".mysqli_real_escape_string($link, $user)."' AND `category_id` ='".mysqli_real_escape_string($link, $cat_id)."' ";
$result = mysqli_query($link, $sql);

if ($result){	
echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Categories Updated</strong></div>');

} /*else {

echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Invalid query: ' . mysqli_error() . '</strong></div>');
echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $sql . '</strong></div>');
}*/

mysqli_close($link); 

?>

