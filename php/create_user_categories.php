

<?php 

session_start();

include("connection.php");

//			$newid = $_SESSION['id'];
			$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));

			for($id=1;$id<6;$id++){
				for($i=1;$i<18;$i++){
				$sql = "INSERT INTO `user_categories`(`user_id`, `category_id`, `order`, `hide`, `date_created`) VALUES ('$id','$i','$i','0','$date');";
				mysqli_query($link, $sql);}
			}
			

?>
