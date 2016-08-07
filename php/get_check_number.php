<?php 

include("connection.php");

if ($_SERVER['REQUEST_METHOD']== "POST") {
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   } 
$acct = test_input($_POST['acct']);


$sql = "SELECT CASE WHEN isnull(MAX(check_number)) THEN 0 ELSE MAX(check_number) END as 'cknum' FROM `checkbook` WHERE `account_id` = '".mysqli_real_escape_string($link, $_POST['acct'])."' ";
$result = mysqli_query($link, $sql); 

$row = mysqli_fetch_array($result);

$check_number = $row['cknum'];  //yService->getValue(); // makes an api and db call

 echo $check_number; // write it to the output
 }
mysqli_close($link); 

?>
