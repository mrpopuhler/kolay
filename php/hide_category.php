<?php 
session_start();

include("connection.php");
$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
$user = $_SESSION['id'];
if($_POST['hide']=='1')
{$hide = '1';$hidden = 'true';} else {$hide = '0';$hidden = 'false';}

$cat_id = $_POST['category_id'];
//$order = $_POST['order'];

//updating hiddenness and order - unfinished
		

$sql = "UPDATE `user_categories` SET `hide`='".mysqli_real_escape_string($link, $hide)."' WHERE `user_id` = '".mysqli_real_escape_string($link, $user)."' AND `category_id` ='".mysqli_real_escape_string($link, $cat_id)."' ";
$result = mysqli_query($link, $sql);


if($result>0) { 
$sql2 = "SELECT `name` FROM `categories` WHERE `category_id` ='".mysqli_real_escape_string($link, $cat_id)."' ";
$result2 = mysqli_query($link, $sql2);
$names = mysqli_fetch_assoc($result2);
		echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Updated hidden status of ' . $names['name'].' to ' . $hidden . '</strong></div>');
	
} else {

echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Invalid query: ' . mysqli_error() . '</strong></div>');
/*echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $sql . '</strong></div>');*/
}

//echo('<div class="alert alert-success alert-dismissible " role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong>Categories Updated</strong></div>');
						

mysqli_close($link); 

?>

