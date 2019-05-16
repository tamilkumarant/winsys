
	<?php
			
			include('../dbconnection/dbconnection_open.php');
	
			$stid = $_GET['stid'];
			
			$sql = "SELECT station_status FROM bwl_station WHERE stid = $stid";
			foreach ($conn->query($sql) as $row) 
			{
				$station_status =  $row['station_status'];
			}
			
			echo $station_status;
			
			if($station_status == 1)
			{
				$query = "UPDATE bwl_station SET  station_status = '0' where stid = $stid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			
			else
			{
				$query = "UPDATE bwl_station SET  station_status = '1' where stid = $stid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			
			include('../dbconnection/dbconnection_close.php');
			
			header("Location: ../controllers/station.php");
			
			exit(0);
	?>
   