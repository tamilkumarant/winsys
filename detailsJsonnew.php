<?php
include 'dynDBnew.php';
header('Access-Control-Allow-Origin: *');

header("Content-type: text/json");
date_default_timezone_set('Asia/Singapore'); 

$sid =  $_GET['sid'];
$type =  $_GET['type'];
$flowtype =  $_GET['flowtype'];
$invertlevel =  $_GET['invertlevel'];

            $reqtype = 'trc';
            $filter = new stdClass;

            //$filter->sid = 'CWS001'; 
            $filter->sid = $sid; 
            //$filter->attr = $type; 
            $filter->end = round(microtime(true) *1000);
            $filter->start = $filter->end - (60*3600*24*1000);
            //print_r($filter);
            $result = _getdata_dyndb($reqtype, $filter);
			// echo '<pre>';
			// print_r($result);exit;
			$table_data = [];
			$data = [];
			$maintenance = [];
			$box[0] = ['ts'=>'N/A','lvl'=>'N/A','fl'=>'N/A','bl'=>'N/A'];
			$box[1] = ['ts'=>'N/A','waterlevel'=>'N/A','m'=>'N/A','bl'=>'N/A'];
			$box[2] = ['ts'=>'N/A','ra'=>'N/A','mt'=>'N/A','bl'=>'N/A'];
			$i=0;
            foreach ($result as $row) {
				
				
				$tabledatarow = [];
				// $datarow = [];
				date_default_timezone_set('Asia/Singapore'); 
				$time = $row['ts'];
				$time = $row['ts'];
				foreach($row as $rowKey=>$rowVal){
					
					
					if($flowtype==0){
						if(in_array($rowKey,['ts','vl','fl','wh','mt','bl']) ){
							if($rowKey=='ts'){
								$rowVal = $rowVal/1000;
								$rowVal = date('Y-m-d H:i',($rowVal));
								$box[$flowtype]['ts'] = $rowVal;
								$tabledatarow[$rowKey] = ($rowVal);
								$box[$flowtype][$rowKey] = ($rowVal);
							}else{
								$tabledatarow[$rowKey] = number_format($rowVal,3);
								$box[$flowtype][$rowKey] = number_format($rowVal,3);
								if($rowKey=='wh'){
									$tabledatarow['lvl'] = number_format($rowVal+$invertlevel,3);								
									$box[$flowtype]['lvl'] = number_format($rowVal+$invertlevel,3);	
								}	
							}								
						}
						
					}else if($flowtype==1){
						if(in_array($rowKey,['ts','m','mt','wr','bl']) ){
							if($rowKey=='ts'){
								$rowVal = $rowVal/1000;
								$rowVal = date('Y-m-d H:i',($rowVal));
								$box[$flowtype]['ts'] = $rowVal;
								$tabledatarow[$rowKey] = $rowVal;
								$box[$flowtype][$rowKey] = $rowVal;
								
							}else if($rowKey=='wr'){
								$tabledatarow['waterlevel'] = number_format($rowVal+$invertlevel,3);
								$tabledatarow['m'] = number_format($rowVal,3);
								$box[$flowtype]['waterlevel'] = number_format($rowVal+$invertlevel,3);
								$box[$flowtype]['m'] = number_format($rowVal,3);
							}else{
								$tabledatarow[$rowKey] = number_format($rowVal,3);
								$box[$flowtype][$rowKey] = number_format($rowVal,3);
							}
						}
					}else if($flowtype==2){
						if(in_array($rowKey,['ts','ra','mt','bl','rd']) ){
							if($rowKey=='ts'){
								$rowVal = $rowVal/1000;
								$rowVal = date('Y-m-d H:i',($rowVal));
								$box[$flowtype]['ts'] = $rowVal;
								$tabledatarow[$rowKey] = ($rowVal);
							}else{
								$tabledatarow[$rowKey] = number_format($rowVal,3);
								$box[$flowtype][$rowKey] = $rowVal;
							}
						}
					}
					
					/* if( in_array($rowKey,['mt']) && $rowVal==1 ){					
						if(isset($maintenance[$i]['from']) && $maintenance[$i]['from'] ){
							$maintenance[$i]['to'] = $time;
							$maintenance[$i]['color'] = '#ddd';
							$i++;
							$maintenance[$i]['from'] = $time;
						}else{
							$maintenance[$i]['from'] = $time;
						}
					}else if(in_array($rowKey,['mt']) && $rowVal==0){
						$maintenance[$i]['from'] = '';
					} */
					
					if( in_array($rowKey,['mt']) && $rowVal==1 ){					
						if(isset($maintenance[$i]['from']) && $maintenance[$i]['from'] ){
							// $maintenance[$i]['from'] = $time;
							// $maintenance[$i]['to'] = $time;
							// $maintenance[$i]['color'] = '#ddd';
							$i++;
							$maintenance[$i]['from'] = $time;
							$maintenance[$i]['to'] = $time;
							$maintenance[$i]['color'] = '#ddd';
						}else{
							$maintenance[$i]['from'] = $time;
							$maintenance[$i]['to'] = $time;
							$maintenance[$i]['color'] = '#ddd';
							$i++;
						}
					}else if(in_array($rowKey,['mt']) && $rowVal==0){
						$maintenance[$i]['from'] = '';
					}
					
					if($flowtype==0){
						if(in_array($rowKey,['vl','fl','wh']) ){
							$rowVal = (double)($rowVal);
							$data[$rowKey][] = array($time,$rowVal);
							if($rowKey=='wh'){
								$rowVal = $rowVal+$invertlevel;
								$rowVal = ($rowVal);
								$data['lvl'][] = array($time,$rowVal);
							}
						}
					}else if($flowtype==1){
						if(in_array($rowKey,['wr']) ){
							$rowVal = ($rowVal);
							if($rowKey=='wr'){
								$data['waterlevel'][] = array($time,$rowVal+$invertlevel);
								$data['m'][] = array($time,$rowVal);
							}else{							
								$data[$rowKey][] = array($time,$rowVal);
							}
						}
					}else if($flowtype==2){
						$rowVal = ($rowVal);
						if(in_array($rowKey,['ra','rd']) ){
							$data[$rowKey][] = array($time,$rowVal);
						}
					}
					
					// if(!in_array($rowKey,['ts'])){
						// $data[$rowKey][] = array($time,$rowVal);
					// }					
				}
				
				if($tabledatarow){
					$table_data[] = $tabledatarow;
				}
				// if($datarow){
					// $data[] = $datarow;
				// }
				
                // print_r($row);
                /* $time = $row['ts'];
                $val = 0.0;
                if($type === 'wh') {
                    $val = $row['wh'];
                } elseif ($type === 'bl') {
                    $val = $row['bl'];
                } elseif ($type === 'ss') {
                    $val = $row['ss'];
                } */
               /*  if($val != null) {
                    // $data[] = (object)array('date'=>$time, 'value'=>$val);
                    $data[] = array($time,$val);
                    //$timestamps[] = $time;
                } */
            } // foreach
echo json_encode(['data'=>$data,'maintenance'=>$maintenance,'table_data'=>$table_data,'flowtype'=>$flowtype,'all'=>$result,'box'=>$box]);
// print_r($data);
