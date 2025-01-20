<?php

include('../../../config/db.php');
include('../../../classes/report-gold.php');

//////////////////////////////////////////////////////

function change_date_format($date,$time){
  $newdate = explode('-',$date);
  return $newdate[2]."-".$newdate[0]."-".$newdate[1]." ".$time;
}


/////////////////////////////////////////////////////

$raw_date = explode("-",trim($_POST['date']));

$rdate1 = str_replace('/', '-', $raw_date[0]);
$date1 = change_date_format($rdate1,"00:00:00");

$rdate2 = str_replace('/', '-', $raw_date[1]);
$date2 = change_date_format($rdate2,"23:59:59");

$data = array(
  "conn" => $conn,
  "date1" => trim($date1),
  "date2" => trim($date2),
  "type_report" => $_POST['type_report']
);

$report = new Report_gold($data);
$getdata = $report->report();
$getdata = $report->print_report_trans();
if($getdata){
  http_response_code(200);
  echo json_encode($getdata);
}
else{
  http_response_code(404);
  echo "Data Not Found";
}