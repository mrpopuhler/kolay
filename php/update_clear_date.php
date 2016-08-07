<?php 

include("connection.php");

$cleared = $_POST['cleared'];
$clear_date = $_POST['clear_date'];

$sql = "UPDATE `checkbook` SET `clear_date`='".mysqli_real_escape_string($link, $clear_date)."' WHERE `transaction_id` ='".mysqli_real_escape_string($link, $cleared)."' ";
$result = mysqli_query($link, $sql);

if ($result){
echo ('<div class="alert alert-success alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong>Clear date updated</strong></div>');


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

