	  <?php
	
		include('../dbconnection/dbconnection_open.php');
		
		$stid = $_POST['stid'];
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
		
		$sql = "SELECT station_id,station_name  FROM bwl_station WHERE stid = $stid";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() >= 1) 
			{
				echo "station id & station name already exists for another station. Enter another station id or station name";
			}
			else
			{
				$query = "UPDATE bwl_station SET  station_id = '$stationid', station_name = '$stationname', station_latitude = '$stationLatitude', station_longitude = '$stationLongitude', pid = '$pid' where stid = $stid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
		
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/station.php");
		exit(0);
	?>
            