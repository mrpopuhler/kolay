<?php 

session_start();
include("connection.php");

$user = $_SESSION['id'];

if(strlen($user) > 0) {
$sql = "select distinct cat.name AS 'Category Name'
			,cat.payment_cat
        ,cat.deposit_cat
        ,uc.order
        ,uc.hide
        ,cat.user_id
        ,cat.category_id AS 'Cat ID'
from user_categories AS uc
inner Join categories as cat
on cat.category_id=uc.category_id
WHERE (uc.user_id = '".mysqli_real_escape_string($link, $user)."') AND uc.hide = '0' AND cat.deposit_cat = '1' ORDER BY uc.order";
      $result = mysqli_query($link, $sql);
	   while ($row = mysqli_fetch_array($result)){
	   if ($row){
	   	$id = $row['Cat ID'];
     	 	$name = $row['Category Name'];
			echo nl2br('<option value="' . $id . '">' . $name . '</option>');
		} else {
		echo nl2br('<option>No categories retrieved</option>');
		}
		}
		
		echo nl2br('<option value="newCategory" data-toggle="modal" data-target="#categoryModal">Add New Category</option>');
} else {
	echo nl2br('<option value="logOut" action="php/sign_in.php?logout=1" >Log Out</option>');
	header("Location: ". $login);

}
?>