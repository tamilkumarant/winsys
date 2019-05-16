	<?php
		$stid = $_GET['stid'];

		include('../dbconnection/dbconnection_open.php');
		
		$query = "delete from bwl_station WHERE stid = '$stid'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
			
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/station.php");
		exit(0);
	?>
            