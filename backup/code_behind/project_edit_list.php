	<?php

		$pid = $_GET['pid'];
		
		include('../dbconnection/dbconnection_open.php');

		$query = "select pid,project_name,project_description from bwl_project where pid = '$pid'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$stationarray = array();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row_array['pid'] = $row['pid'];
			$row_array['projectname'] = $row['project_name'];
			$row_array['projectdescription'] = $row['project_description'];
			array_push($stationarray,$row_array);
		}
		
		include('../dbconnection/dbconnection_close.php');

	?>