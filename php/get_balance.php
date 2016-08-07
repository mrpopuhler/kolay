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


$sql = "SELECT SUM(amount) as 'balance' FROM `checkbook` WHERE `account_id` = '".mysqli_real_escape_string($link, $_POST['acct'])."' ";
$result = mysqli_query($link, $sql); 

$row = mysqli_fetch_array($result);

$val = $row['balance'];  //yService->getValue(); // makes an api and db call

$number = $val;

// US national format, using () for negative numbers
// and 10 digits for left precision
$balance = number_format($number, 2, '.', ',');
// ($        1,234.57)


 echo trim(json_encode($balance), '"'); // write it to the output
 }
mysqli_close($link); 

?>
