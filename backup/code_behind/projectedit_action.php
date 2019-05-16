	  <?php
	
		include('../dbconnection/dbconnection_open.php');
		
		$pid = $_POST['pid'];
		$projectname=$_POST['projectname'];
		$projectdescription=$_POST['projectdescription'];
		
		$sql = "SELECT project_id,project_name  FROM bwl_project WHERE pid = $pid";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() >= 1) 
			{
				echo "project id & project name already exists for another project. Enter another project id or project name";
			}
			else
			{
				$query = "UPDATE bwl_project SET  project_name = '$projectname', project_description = '$projectdescription' where pid = $pid";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
		
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/project.php");
		exit(0);
	?>
            