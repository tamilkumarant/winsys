	<?php
		
		//read data from the incoming data content.
		
		$putdata = fopen("php://input", "r");
		$devicedata = stream_get_contents($putdata);
		fclose($putdata);

		//decord the data as a json file
		
		$devicedata = '['.$devicedata.']';
		
	//	$devicedata = '[{"al": 2, "bl": 100, "history": {"wl_1": 0.969, "wl_2": 20}, "raw": 898, "sid": "CWS001", "ss": 10.1, "ts_r": "2017-05-21 11:11:11", "wl": 0.965}]';
		
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
		
		if($sid == 'CWS001')
		{
			$eventDate = DateTime::createFromFormat('d/m/y H:i:s', $ts_r, new DateTimeZone('Asia/Singapore'));
			$now = date_format($eventDate, 'Y-m-d H:i:s');
			$ts_r = date('Y-m-d H:i:s',strtotime('+8 hour',strtotime($now)));
		}
		
	
		$host = 'localhost';
		$db   = 'bg';
		$user = 'root';
		$pass = 'root123';
		$charset = 'utf8';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
	   ];
		$conn = new PDO($dsn, $user, $pass, $opt);
		

		
		//echo $sidd;
	
		
		$query = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status) VALUES ('$sid','$ts_r','$wl','$wlmRL','$bl',0)";
		//$query = "INSERT INTO bp_rawdata(device_rawdata,sample_number,system_datetime,deviceID,device_datetime,flow_rate,mean_velocity,volume_total,depth,temperature,insuit_pressure,insuit_temparature,insuit_level,maintenance,w_area,w_range,w_stage) VALUES ('$devicedata','$rs_Sample_number','$currentdate','$rs_deviceID','$rs_datetime','$rs_flowrate','$rs_meanvelocity','$rs_volumetotal','$rs_depth','$rs_temperature','$rs_insut_pressure','$rs_insut_temperature','$rs_insut_level','$rs_maintanance','$rs_area','$rs_range','$rs_stage')";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$conn=null;
		
	?>

