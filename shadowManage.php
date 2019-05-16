<?php


require 'vendor/autoload.php';

$client = new Aws\IotDataPlane\IotDataPlaneClient([
    'region'  => 'ap-southeast-1',
    'version' => 'latest',
]);

use Aws\IotDataPlane\IotDataPlaneClient;

	$params = (isset($_REQUEST)&& ($_REQUEST))?($_REQUEST):array();
	
		
	$file = fopen("mytest1.txt","w");
	echo fwrite($file,date('d-M-Y H:i:s')."\n\n shadow manage params firlst".json_encode($params));
	fclose($file); 
	
	$station_id = (isset($params['pub_id']) && ($params['pub_id'])!='' )? strtoupper($params['pub_id']):'';
	if($station_id){
		
		$location = (isset($params['location']) && ($params['location'])!='' )?($params['location']):'';
		$cope_level = (isset($params['cope_level']) && ($params['cope_level'])!='' )?($params['cope_level']):'';
		$invert_level = (isset($params['invert_level']) && ($params['invert_level'])!='' )?($params['invert_level']):'';
		$calibration_m = (isset($params['calibration_m']) && ($params['calibration_m'])!='' )?($params['calibration_m']):'';
		$calibration_c = (isset($params['calibration_c']) && ($params['calibration_c'])!='' )?($params['calibration_c']):'';
		$spike_threshold = (isset($params['spike_threshold']) && ($params['spike_threshold'])!='' )?($params['spike_threshold']):'';
		// $offset_o = ( isset($params['offset_o']) )?($params['offset_o']):'';
		$offset_o = $params['offset_o'];// (isset($params['offset_o']) && ((double)$params['offset_o'])>=0 && ($params['offset_o'])!='' )?($params['offset_o']):'';
		$delta = (isset($params['delta']) && ($params['delta'])!='' )?($params['delta']):'';
		$mode = (isset($params['mode']) && ($params['mode'])!='' )?($params['mode']):'';
		$mode = (isset($params['mode']) && ($params['mode'])!='' )?($params['mode']):'';
		$mode = (isset($params['mode']) && ($params['mode'])!='' )?($params['mode']):'';
		$b1 = (isset($params['b1'])  )?($params['b1']):'';
		$b2 = (isset($params['b2'])  )?($params['b2']):'';
		$b3 = (isset($params['b3'])  )?($params['b3']):'';
		$b4 = (isset($params['b4'])  )?($params['b4']):'';
		$b5 = (isset($params['b5'])  )?($params['b5']):'';
		$h1 = (isset($params['h1'])  )?($params['h1']):'';
		$h2 = (isset($params['h2'])  )?($params['h2']):'';
		$h3 = (isset($params['h3'])  )?($params['h3']):'';
		$h4 = (isset($params['h4'])  )?($params['h4']):'';
		$h5 = (isset($params['h5'])  )?($params['h5']):'';
		$w1 = (isset($params['w1'])  )?($params['w1']):'';
		$w2 = (isset($params['w2'])  )?($params['w2']):'';
		$w3 = (isset($params['w3'])  )?($params['w3']):'';
		$w4 = (isset($params['w4'])  )?($params['w4']):'';
		$w5 = (isset($params['w5'])  )?($params['w5']):'';
		
		$desired = array();
		if($location) { $desired['location']=$location; }
		if($cope_level) { $desired['cope_level']=(double)$cope_level; }
		if($invert_level) { $desired['invert_level']=(double)$invert_level; }
		if($calibration_m) { $desired['calibration_m']=(double)$calibration_m; }
		if($calibration_c) { $desired['calibration_c']=(double)$calibration_c; }
		if($offset_o==='0' || $offset_o!='') { $desired['offset']=(double)$offset_o; }
		if($delta) { $desired['delta']=(double)$delta; }
		if($spike_threshold) { $desired['spike_threshold']=(double)$spike_threshold; }
		if($mode) { $desired['mode']=(double)$mode; }
		if($b1==='0' || $b1) { $desired['b1']=(double)$b1; }
		if($b2==='0' || $b2) { $desired['b2']=(double)$b2; }
		if($b3==='0' || $b3) { $desired['b3']=(double)$b3; }
		if($b4==='0' || $b4) { $desired['b4']=(double)$b4; }
		if($b5==='0' || $b5) { $desired['b5']=(double)$b5; }
		if($h1==='0' || $h1) { $desired['h1']=(double)$h1; }
		if($h2==='0' || $h2) { $desired['h2']=(double)$h2; }
		if($h3==='0' || $h3) { $desired['h3']=(double)$h3; }
		if($h4==='0' || $h4) { $desired['h4']=(double)$h4; }
		if($h5==='0' || $h5) { $desired['h5']=(double)$h5; }
		if($w1==='0' || $w1) { $desired['w1']=(double)$w1; }
		if($w2==='0' || $w2) { $desired['w2']=(double)$w2; }
		if($w3==='0' || $w3) { $desired['w3']=(double)$w3; }
		if($w4==='0' || $w4) { $desired['w4']=(double)$w4; }
		if($w5==='0' || $w5) { $desired['w5']=(double)$w5; }

		
		
		 $file = fopen("mytest.txt","w");
		echo fwrite($file,date('d-M-Y H:i:s')."\n\n shadow manage desired ".json_encode($desired));
		fclose($file);  
		
		$params = [
			'thingName' => $station_id,
		];

		$result = $client->getThingShadow($params);

		$shadow = $result['payload']->getContents();
		
		$shadow_j = json_decode($shadow);

		$payload_json = array(
						  'state' => array(
							'reported' => $desired
						)
					);


		$payload = json_encode($payload_json);
		
	
		
		$result_mod = $client->updateThingShadow([
			'payload' => $payload,
			'thingName' => $station_id,
		]);


		print_r($result_mod);
		exit;
	}
	

