	<?php
		
		//read data from the incoming data content.
		
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
	
			date_default_timezone_set('Asia/Singapore');
			$currentdate = date('Y-m-d H:i:s', time());
			
			$rawMin = 750;
			$rawMax = 900;
			$rawRange = $rawMax - $rawMin;
			$rawValue = $rawMin + $rawRange * (mt_rand() / mt_getrandmax()); 
			$rawValue = round($rawValue, 0);			
			$max1 = 3.0;
			$min1 = 0.0;
			$range1 = $max1 - $min1;
			$num1 = $min1 + $range1 * (mt_rand() / mt_getrandmax());    
			$num1 = round($num1, 2);
			$num11 = $num1 + 100;
			
			$query = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS029','$currentdate', '$num1','$num11','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			$max2 = 3.0;
			$min2 = 0.0;
			$range2 = $max2 - $min2;
			$num2 = $min2 + $range2 * (mt_rand() / mt_getrandmax());    
			$num2 = round($num2, 2);
			$num22 = $num2 + 100;
			
			$query1 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS025','$currentdate', '$num2','$num22','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query1);
			$stmt->execute();
			
			$max3 = 3.0;
			$min3 = 0.0;
			$range3 = $max3 - $min3;
			$num3 = $min3 + $range3 * (mt_rand() / mt_getrandmax());    
			$num3 = round($num3, 2);
			$num33 = $num3 + 100;
			
			$query2 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS027','$currentdate', '$num3','$num33','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query2);
			$stmt->execute();
			
			$max5 = 3.0;
			$min5 = 0.0;
			$range5 = $max5 - $min5;
			$num5 = $min5 + $range5 * (mt_rand() / mt_getrandmax());    
			$num5 = round($num5, 2);
			$num55 = $num5 + 100;
			
			$query4 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS002','$currentdate', '$num5','$num55','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query4);
			$stmt->execute();
			
			$max6 = 3.0;
			$min6 = 0.0;
			$range6 = $max6 - $min6;
			$num6 = $min6 + $range6 * (mt_rand() / mt_getrandmax());    
			$num6 = round($num6, 2);
			$num66 = $num6 + 100;
			
			$query5 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS003','$currentdate', '$num6','$num66','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query5);
			$stmt->execute();
			
			$max7= 3.0;
			$min7= 0.0;
			$range7= $max7- $min7;
			$num7= $min7+ $range7* (mt_rand() / mt_getrandmax());    
			$num7= round($num7, 2);
			$num77= $num7+ 100;
			
			
			$query6 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS007','$currentdate', '$num7','$num77','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query6);
			$stmt->execute();
			
			$max8= 3.0;
			$min8= 0.0;
			$range8= $max8- $min8;
			$num8= $min8+ $range8* (mt_rand() / mt_getrandmax());    
			$num8= round($num8, 2);
			$num88= $num8+ 100;
			
			$query7 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS010','$currentdate', '$num8','$num88','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query7);
			$stmt->execute();
			
			$max9= 3.0;
			$min9= 0.0;
			$range9= $max9- $min9;
			$num9= $min9+ $range9* (mt_rand() / mt_getrandmax());    
			$num9= round($num9, 2);
			$num99= $num9+ 100;
			
			$query8 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS011','$currentdate', '$num9','$num99','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query8);
			$stmt->execute();
			
			$max10= 3.0;
			$min10= 0.0;
			$range10= $max10- $min10;
			$num10= $min10+ $range10* (mt_rand() / mt_getrandmax());    
			$num10= round($num10, 2);
			$num1010= $num10+ 100;
			
			$query9 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS012','$currentdate', '$num10','$num1010','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query9);
			$stmt->execute();
			
			$max11= 3.0;
			$min11= 0.0;
			$range11= $max11- $min11;
			$num11= $min11+ $range11* (mt_rand() / mt_getrandmax());    
			$num11= round($num11, 2);
			$num1111= $num11+ 100;
			
			$query10 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS013','$currentdate', '$num11','$num1111','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query10);
			$stmt->execute();
			
			
			$max12= 3.0;
			$min12= 0.0;
			$range12= $max12- $min12;
			$num12= $min12+ $range12* (mt_rand() / mt_getrandmax());    
			$num12= round($num12, 2);
			$num1212= $num12+ 100;
			
			
			$query11 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS014','$currentdate', '$num12','$num1212','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query11);
			$stmt->execute();
			
			$max13= 3.0;
			$min13= 0.0;
			$range13= $max13- $min13;
			$num13= $min13+ $range13* (mt_rand() / mt_getrandmax());    
			$num13= round($num13, 2);
			$num1313= $num13+ 100;
			
			
			$query12 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS015','$currentdate', '$num13','$num1313','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query12);
			$stmt->execute();
			
			$max14= 3.0;
			$min14= 0.0;
			$range14= $max14- $min14;
			$num14= $min14+ $range14* (mt_rand() / mt_getrandmax());    
			$num14= round($num14, 2);
			$num1414= $num14+ 100;
			
			$query13 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS016','$currentdate', '$num14','$num14','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query13);
			$stmt->execute();
			
			$max15= 3.0;
			$min15= 0.0;
			$range15= $max15- $min15;
			$num15= $min15+ $range15* (mt_rand() / mt_getrandmax());    
			$num15= round($num15, 2);
			$num1515= $num15+ 100;
			
			$query14 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS017','$currentdate', '$num15','$num1515','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query14);
			$stmt->execute();
			
			$max16= 3.0;
			$min16= 0.0;
			$range16= $max16- $min16;
			$num16= $min16+ $range16* (mt_rand() / mt_getrandmax());    
			$num16= round($num16, 2);
			$num1616= $num16+ 100;
			
			
			$query15 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS019','$currentdate', '$num16','$num1616','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query15);
			$stmt->execute();
			
			$max17= 3.0;
			$min17= 0.0;
			$range17= $max17- $min17;
			$num17= $min17+ $range17* (mt_rand() / mt_getrandmax());    
			$num17= round($num17, 2);
			$num1717= $num17+ 100;
			
			$query16 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS020','$currentdate', '$num17','$num1717','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query16);
			$stmt->execute();
			
			$max18= 3.0;
			$min18= 0.0;
			$range18= $max18- $min18;
			$num18= $min18+ $range18* (mt_rand() / mt_getrandmax());    
			$num18= round($num18, 2);
			$num1818= $num18+ 100;
			
			$query17 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS021','$currentdate', '$num18','$num1818','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query17);
			$stmt->execute();
			
			$max19= 3.0;
			$min19= 0.0;
			$range19= $max19- $min19;
			$num19= $min19+ $range19* (mt_rand() / mt_getrandmax());    
			$num19= round($num19, 2);
			$num1919= $num19+ 100;
			
			$query18 = "INSERT INTO raw_data(station_id,datetime,waterlevel_meter,waterlever_mrl,battery_voltage,maintenance_status,rawValue) VALUES ('CWS022','$currentdate', '$num19','$num1919','12.35',0,'$rawValue')";
			$stmt = $conn->prepare($query18);
			$stmt->execute();
			
			
			
			
			
			
			
			
			
			$conn=null;
		
	?>

