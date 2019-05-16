<?php
include 'dynDBnew.php';
header('Access-Control-Allow-Origin: *');

header("Content-type: text/json");
// error_reporting(1);
date_default_timezone_set('Asia/Singapore'); 

$all_stations =  $_REQUEST['all_sid'];
// print_r $all_stations;
// return json_encode(array('array'=>$all_stations));exit;
$data = [];

$resultStations = [];

foreach ($all_stations as $key => $station) {

	$sid = $station['pub_id'];
	$flowtype = $station['type'];
	$invertlevel = isset($station['invertlevel']) ? ($station['invertlevel']) : 0 ;
    $reqtype = 'rt';
    $filter = new stdClass;
    $filter->sid = $sid; 
    $result = _getdata_dyndb($reqtype, $filter);
	// $data[$sid] = $result;
    $resultStations[$sid] = $station;
    $data = [];
	foreach($result as $rowKey=>$rowVal){


		if($flowtype==0){
			if(in_array($rowKey,['ts','vl','wf','wh','mt']) ){
				if($rowKey=='ts'){
					$rowVal = $rowVal/1000;
					$rowVal = date('Y-m-d H:i',($rowVal));
					$resultStations[$sid]['ts'] = $rowVal;
					$resultStations[$sid][$rowKey] = ($rowVal);
				}else{
					$resultStations[$sid][$rowKey] = number_format($rowVal,3);
					if($rowKey=='wh'){
						$resultStations[$sid]['lvl'] = $rowVal+$invertlevel;	
					}
				}					
			}
			
		}else if($flowtype==1){
			if(in_array($rowKey,['ts','m','mt','wr']) ){
				if($rowKey=='ts'){
					$rowVal = $rowVal/1000;
					$rowVal = date('Y-m-d H:i',($rowVal));
					$resultStations[$sid]['ts'] = $rowVal;
					$resultStations[$sid][$rowKey] = ($rowVal);
				}else{
					if($rowKey=='wr'){
						$resultStations[$sid]['waterlevel'] = number_format($rowVal+$invertlevel,3);
						$resultStations[$sid]['m'] = number_format($rowVal,3);
					}else{
						$resultStations[$sid][$rowKey] = number_format($rowVal,3);
					}
				}
			}
		}else if($flowtype==2){
			if(in_array($rowKey,['ts','ra','mt']) ){
				if($rowKey=='ts'){
					$rowVal = $rowVal/1000;
					$rowVal = date('Y-m-d H:i',($rowVal));
					$resultStations[$sid]['ts'] = $rowVal;
					$resultStations[$sid][$rowKey] = ($rowVal);
				}else{
					$resultStations[$sid][$rowKey] = number_format($rowVal,3);
				}
			}
		}
	}
} 

echo json_encode(['data'=>$resultStations]);
// print_r($data);
