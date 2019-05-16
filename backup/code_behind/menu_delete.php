	<?php
		$id = $_GET['id'];

		include('../dbconnection/dbconnection_open.php');
		
		$query = "delete from menu WHERE id = '$id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
			
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/menu.php");
		exit(0);
	?>
            