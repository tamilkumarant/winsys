	<?php
		include('../dbconnection/dbconnection_open.php');
		
		$stationid=$_POST['stationid'];
		$stationname=$_POST['stationname'];
		$stationLatitude=$_POST['stationLatitude'];
		$stationLongitude=$_POST['stationLongitude'];
		$projectname=$_POST['projectname'];
		
		$sql = "SELECT pid FROM bwl_project where  project_name = '$projectname'";
		foreach ($conn->query($sql) as $row) 
		{
			$pid =  $row['pid'];
		}
		
		$sql = "SELECT * FROM bwl_station WHERE station_id = '$stationid'";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() == 0) 
			{
				$query = "INSERT INTO bwl_station (station_id,station_name,station_latitude, station_longitude,pid) VALUES ('$stationid','$stationname','$stationLatitude','$stationLongitude','$pid')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			else
			{
				echo "Station ID already exists. Enter another station ID";
			}
		}
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/station.php");
		exit(0);
	?>
          