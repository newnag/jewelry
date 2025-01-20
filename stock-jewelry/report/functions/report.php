<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('../../../config/db.php');
include('../../../classes/report-jewelry.php');

//////////////////////////////////////////////////////

function change_date_format($date){
  $newdate = explode('-',$date);
  return $newdate[2]."-".$newdate[0]."-".$newdate[1];
}


/////////////////////////////////////////////////////

$raw_date = explode("-",trim($_POST['date']));

$rdate1 = str_replace('/', '-', $raw_date[0]);
$date1 = change_date_format($rdate1);

$rdate2 = str_replace('/', '-', $raw_date[1]);
$date2 = change_date_format($rdate2);

$data = array(
  "conn" => $conn
);

$report = new Report_jewelry($data);
$getdata = $report->report_sale($date1,$date2);
if($getdata){
  http_response_code(200);
  echo json_encode($getdata);
}
else{
  http_response_code(404);
  echo "Data Not Found";
}