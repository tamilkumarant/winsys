	<?php

		$stid = $_GET['stid'];
		
		include('../dbconnection/dbconnection_open.php');

		$query = "select stid,station_id,station_name,station_latitude,station_longitude,pid from bwl_station where stid = '$stid'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$stationarray = array();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row_array['stid'] = $row['stid'];
			$row_array['stationid'] = $row['station_id'];
			$row_array['stationname'] = $row['station_name'];
			$row_array['stationLatitude'] = $row['station_latitude'];
			$row_array['stationLongitude'] = $row['station_longitude'];
			$row_array['pid'] = $row['pid'];
			array_push($stationarray,$row_array);
		}
		
		$pid = $row_array['pid'];
		
		$sql = "SELECT project_name FROM bwl_project where  pid = $pid";
		foreach ($conn->query($sql) as $row) 
		{
			$projectname =  $row['project_name'];
		}
		
		include('../dbconnection/dbconnection_close.php');

	?>