<?php 



// Database Connection
session_start();
include("connection.php");


$date = time();
// Download the file

$filename = 'checkbook-'. $date .'.csv';
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
header('Pragma: no-cache');
header('Expires: 0');

include("data.php");


?>
