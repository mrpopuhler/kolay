<?php 
// Database Connection
session_start();
include("connection.php");

$fp = fopen('php://temp', 'w+');
	
//query get data
	$sql = mysqli_query($link,"SELECT `transaction_date`, `check_number`, `clear_date`, `category`, `description`, `amount`, `cleared` , `account_name` FROM checkbook c INNER JOIN accounts a ON c.account_id = a.account_id WHERE `user_id` = ". $_SESSION['id'] ." ORDER BY `transaction_date` DESC");
	while($data = mysqli_fetch_assoc($sql)){
	fputcsv($fp, $data);	
	}
rewind($fp);
$csv_contents = stream_get_contents($fp);
fclose($fp);

echo "transaction_date, check_number, clear_date, category, description, amount, cleared, account\r\n";
echo $csv_contents;
?>