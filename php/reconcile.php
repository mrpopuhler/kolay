<?php 

include("connection.php");

$cleared = $_POST['cleared'];
$query = "SELECT * FROM `checkbook` WHERE `transaction_id` ='".mysqli_real_escape_string($link, $cleared)."' LIMIT 1";
$result = mysqli_query($link, $query);

if($result) {

$row = mysqli_fetch_array($result);
 if ($row['cleared']==0) {
 	$sql = "UPDATE `checkbook` SET `cleared`='1' WHERE `transaction_id` ='".mysqli_real_escape_string($link, $cleared)."' ";
	mysqli_query($link, $sql);
	echo ('<div class="alert alert-success alert-dismissible " role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Transaction reconciled</strong></div>');


 }
 elseif ($row['cleared']==1) {
 	$sql = "UPDATE `checkbook` SET `cleared`='0' WHERE `transaction_id` ='".mysqli_real_escape_string($link, $cleared)."' ";
	mysqli_query($link, $sql);
	echo ('<div class="alert alert-success alert-dismissible " role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Transaction unreconciled</strong></div>');
 }

} else {
echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Invalid query: ' . mysqli_error() . '</strong></div>');
echo ('<div class="alert alert-warning alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Whole query: ' . $query . '</strong></div>');
}


	 

mysqli_close($link); 

?>

