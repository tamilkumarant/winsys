	<?php
		include('../dbconnection/dbconnection_open.php');
		
		$projectid=$_POST['projectid'];
		$projectname=$_POST['projectname'];
		$projectdescription=$_POST['projectdescription'];
		
		$sql = "SELECT * FROM bwl_project WHERE project_id = '$projectid'";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() == 0) 
			{
				$query = "INSERT INTO bwl_project(project_id,project_name,project_description) VALUES ('$projectid','$projectname','$projectdescription')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			else
			{
				echo "project ID already exists. Enter another project ID";
			}
		}
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/project.php");
		exit(0);
	?>
          