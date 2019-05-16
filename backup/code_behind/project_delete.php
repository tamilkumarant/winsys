	<?php
		$pid = $_GET['pid'];

		include('../dbconnection/dbconnection_open.php');
		
		$query = "delete from bwl_project WHERE pid = '$pid'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
			
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/project.php");
		exit(0);
	?>
            