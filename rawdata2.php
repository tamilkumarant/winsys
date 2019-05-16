	<?php
		
		//read data from the incoming data content.
		
		$putdata = fopen("php://input", "r");
		$devicedata = stream_get_contents($putdata);
		fclose($putdata);

		//decord the data as a json file
		
		//$devicedata = '['.$devicedata.']';
		
		$devicedata = '[{ "sid" : "CWS001",  "ts_r" : "23/05/17 12:26:18", "raw" : 988,  "wl" : 82.8, "bl" : 12.85,  "ss" : 39, "al" : 2 ,  "history" : { "wl_1" : 83.2    }}]';
		
		$json_sensordata = json_decode($devicedata, true);
		
		date_default_timezone_set('Asia/Singapore');
		$currentdate = date('Y-m-d H:i:s', time());
		foreach($json_sensordata as $data_item)
		{
		
			$bl = $data_item['bl'];
			$sid = $data_item['sid'];
			$wl = $data_item['wl'];
			$wl = $wl/100;
			$wlmRL = $wl + 100;
			$ts_r = $data_item['ts_r'];
			
		}
		echo $sid;
		
		if($sid == 'CWS001')
		{
			$eventDate = DateTime::createFromFormat('d/m/y H:i:s', $ts_r, new DateTimeZone('Asia/Singapore'));
			$now = date_format($eventDate, 'Y-m-d H:i:s');
			
			echo $now;
			echo "<br>";
			
			$ts_r = date('Y-m-d H:i:s',strtotime('+8 hour',strtotime($now)));
			
			
		}
		
		echo $ts_r;
		
	
		
		
		
		
	
		
		
	?>

