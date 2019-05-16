	<?php

		$id = $_GET['id'];
		
		include('../dbconnection/dbconnection_open.php');

		$query = "select id,menu from menu where id = '$id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$stationarray = array();
		$data=array();
		while($row = $stmt->fetch())
		{
			$data['id'] = $row['id'];
			$data['menu'] = $row['menu'];
		}
		
		include('../dbconnection/dbconnection_close.php');

	?>