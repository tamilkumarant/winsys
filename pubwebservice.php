<?php 

	function dbconnection(){
		$servername = "127.0.0.1";
		$username = "root";
		$password = "root123";
		$dbname = "bg";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}else{
			return $conn;
		}		
	}
	function percentage($percentage,$totalWidth){
		return ($percentage / 100) * $totalWidth;		
	}
	function p($args,$exit=false){
		echo '<pre>';
		print_r($args);
		if($exit){
			exit;
		}
	}
	
	$conn = dbconnection();
	$data = array();
	$login = false;
	$username = isset($_REQUEST['u'])?($_REQUEST['u']):null;
	$password = isset($_REQUEST['p'])?($_REQUEST['p']):null;
	$sql = "SELECT * FROM users WHERE username='{$username}' AND password_text='{$password}' AND is_active=0";
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		$login = true;
	}
	
	$sql = "SELECT * FROM bwl_station WHERE is_active=0";
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		
		while($val = $result->fetch_assoc()){ 
		
			$sql2 = "SELECT * FROM raw_data WHERE station_id='{$val['station_id']}' ORDER BY datetime DESC LIMIT 1";
			$result2 = $conn->query($sql2);
			if ($result2->num_rows > 0) {
				
				while($rawdata = $result2->fetch_assoc()){ 
				
												
					$datetime = isset($rawdata['datetime'])?(date('Y-m-d H:i:s',strtotime($rawdata['datetime']))):'';
					$waterlevel_meter = isset($rawdata['waterlevel_meter'])?($rawdata['waterlevel_meter']):0;
					$waterlever_mrl = isset($rawdata['waterlever_mrl'])?($rawdata['waterlever_mrl']):0;
					$maintenance_status = isset($rawdata['maintenance_status'])?($rawdata['maintenance_status']):0;
					
					
					
					$totalPercentage = ($val['copelevel'])-($val['invertlevel']);
					
					if($rawdata){
						
						$cal_percentage50 = percentage(50,$totalPercentage)+$val['invertlevel'];
						$cal_percentage75 = percentage(75,$totalPercentage)+$val['invertlevel'];
						$cal_percentage90 = percentage(90,$totalPercentage)+$val['invertlevel'];	
						$cal_percentage = $totalPercentage+$val['invertlevel'];		
												
						if($maintenance_status==1 ||  $val['maintenance']){
							$flag =3;
						}else if($waterlever_mrl>=$cal_percentage){
							$flag =2;
						}else if($waterlever_mrl>$cal_percentage50){
							$flag =1;
						}else{
							$flag =0;
						}
						$row_array = array();
						$row_array['waterlevel'] = $waterlevel_meter;
						$row_array['flag'] = $flag;
						$row_array['observation_time'] = $datetime;
						$row_array['station_id'] = $val['station_id'];
						$row_array['desc'] = $val['station_name'];
						$data[] = $row_array;
					}
					
					
				}
			}
		}
	}
	
	$conn->close();
	
	header('Content-type: text/xml');
	echo '<xml>';

	if($data && $login){ 
	
		// header('Content-type: text/xml');
		// echo '<xml>';
		foreach($data as $key => $value) {
			
			if(is_array($value)) {
				foreach($value as $tag => $val) {
					print_r('<'.$tag.'>'.($val).'</'.$tag.'>');
				}
			}
			
		}


	}
	
	echo '</xml>';
	
	?>