<?php 

session_start();
include("connection.php");
   function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
   } 
   date_default_timezone_set('America/Chicago');
   $offset = date_offset_get(new DateTime)/3600;
   
   // returns pos/neg decimal (eg. -7 if in PST and DST is active.)
   // remember there are time zones with 30 and 45 min offsets
   // http://en.wikipedia.org/wiki/Time_zone
	$date = date("Y-m-d H:i:s",($_SERVER['REQUEST_TIME']));
	$trans_date = date("Y-m-d",($_SERVER['REQUEST_TIME']));

function cleanData($a) {

    if(preg_match("/^[$0-9,.]+$/", $a)) 
	    {
    	$a = str_replace(',', '', $a);
    	$a = str_replace('$', '', $a);
		}
     return $a;
} 

$user = $_SESSION['id'];
$acctname = test_input($_POST['newAccountName']);
$sql = "INSERT INTO `accounts` (`user_id`,`account_name`,`primary`,`create_date`) VALUES('$user','$acctname','0','$date');";
mysqli_query($link, $sql);
$acct_id = mysqli_insert_id($link);
echo $acct_id;

$balance = cleanData($_POST['newStartingBalance']);
$newBalance = test_input($balance);
$new_balance = test_input($balance);
$query = "INSERT INTO `checkbook` (`transaction_date`,`account_id`,`category`,`amount`,`current_balance`,`description`,`check_number`,`clear_date`,`cleared`,`last_edit`)
 VALUES('$trans_date','$acct_id','Starting Balance','$new_balance','$newBalance','Starting Balance','NULL','NULL','1','$date');";		
mysqli_query($link, $query);		

header("Location: " . $mainpage);
?>