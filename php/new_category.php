<?php 
session_start();

include("connection.php");
$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
$user = $_SESSION['id'];
$new_name = $_POST['new_name'];
if($_POST['hide_category']=='1')
{$hide = '1';} else {$hide = '0';}
$payment = $_POST['payment_category'];
$deposit = $_POST['deposit_category'];

if($new_name<>''){
$query = "INSERT INTO `categories`(`name`, `payment_cat`, `deposit_cat`, `user_id`, `date_created`) VALUES ('$new_name','$payment','$deposit','$user','$date');";
mysqli_query($link, $query);

$cat_id=mysqli_insert_id($link);
$get_next_query = "SELECT * FROM `user_categories`
WHERE `user_id` = '".mysqli_real_escape_string($link, $user)."'
ORDER BY `order`";
$result_next = mysqli_query($link, $get_next_query);

while($row = mysqli_fetch_array($result_next)) { 
$next = $row['order']; 
}
$next +=1;

$user_query = "INSERT INTO `user_categories`(`category_id`, `user_id`, `order`, `hide`, `date_created`) VALUES ('$cat_id','$user','$next','$hide','$date');";
mysqli_query($link, $user_query);
}

mysqli_close($link); 

?>

