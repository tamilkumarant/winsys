 <?php
		include('../dbconnection/dbconnection_open.php');
		
		$data = array();

		$query = "SELECT station_id, station_name, station_latitude, station_longitude from bwl_station where station_status = '1'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row_array['stationID'] = $row['station_id'];
			$row_array['stationname'] = $row['station_name'];
			$row_array['lat'] = $row['station_latitude'];
			$row_array['lon'] = $row['station_longitude'];
			$row_array['image'] = 'green';
			array_push($data,$row_array);
			
		}

		
		echo json_encode($data);
		
		include('../dbconnection/dbconnection_close.php');
		
		
?>