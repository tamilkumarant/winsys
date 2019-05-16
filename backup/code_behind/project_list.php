	<?php
						
		include('../dbconnection/dbconnection_open.php');
								
		//if($utid == 1)
	//	{
			$sql = "Select pid,project_name from bwl_project";
			foreach ($conn->query($sql) as $row) 
			{
				echo "<option id='$row[project_name]' value='$row[project_name]'>$row[project_name]</option>";
			}
	//	}
	//	else
	//	{
		//	$sql = "select pid FROM bp_user where  uid = $uid";
		//	foreach ($conn->query($sql) as $row) 
		//	{
			//	$pid =  $row['pid'];
		//	}
			
		//	$sql = "Select pid,project_name from bwl_project where pid = $pid";
		//	foreach ($conn->query($sql) as $row) 
			//{
			//	echo "<option id='$row[project_name]' value='$row[project_name]'>$row[project_name]</option>";
			//}
		//}
		include('../dbconnection/dbconnection_close.php');

	?>