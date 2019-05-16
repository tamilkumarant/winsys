<?Php
	
	include('../dbconnection/dbconnection_open.php');
	
	$data = array();
	
	$query = "select id,menu from menu";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$data =	array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$data[] = array('id'=>$row['id'],'menu'=>$row['menu']);		
	}
	
	
	
	
	include('../dbconnection/dbconnection_close.php');
?>