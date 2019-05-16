<?Php
	@$projectname=$_GET['project_name'];

	include('../dbconnection/dbconnection_open.php');
	
	$sql = "SELECT pid FROM bwl_project where  project_name = '$projectname'";
	foreach ($conn->query($sql) as $row) 
	{
		$pid =  $row['pid'];
	}
		$pid = 1;
	
	//$station_id = 'ST01';
	
	$data = array();
	
	$query = "select station_id,station_name from bwl_station where pid = 1";
	$stmt = $conn->prepare($query);
	$stmt->execute();
		
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row_array['stationID'] = $row['station_id'];
			$row_array['stationname'] = $row['station_name'];
			array_push($data,$row_array);
			
		}

		
		echo json_encode($data);
	
	
	
	
	include('../dbconnection/dbconnection_close.php');
?>