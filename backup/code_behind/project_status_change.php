
	<?php
			
			include('../dbconnection/dbconnection_open.php');
	
			$pid = $_GET['pid'];
			
			$sql = "SELECT project_status FROM bwl_project WHERE pid = $pid";
			foreach ($conn->query($sql) as $row) 
			{
				$project_status =  $row['project_status'];
			}
			
			echo $project_status;
			
			if($project_status == 1)
			{
				$query = "UPDATE bwl_project SET  project_status = '0' where pid = $pid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			
			else
			{
				$query = "UPDATE bwl_project SET  project_status = '1' where pid = $pid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			
			include('../dbconnection/dbconnection_close.php');
			
			header("Location: ../controllers/project.php");
			
			exit(0);
	?>
   