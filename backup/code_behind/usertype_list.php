	<?php
						
		include('../dbconnection/dbconnection_open.php');
		
		$role_id=isset($_GET['role_id'])?($_GET['role_id']):0;
		$sql = "Select utid,user_type from bwl_user_type";
		foreach ($conn->query($sql) as $row) 
		{
			echo "<option id='$row[utid]' value='$row[utid]' ";
			if($row['utid']==$role_id){
				echo ' selected';
			}
			echo ">$row[user_type]</option>";
		}
		
/*
		
		if($utid == 1)
		{
			$sql = "Select utid,usertypename from bp_usertype";
			foreach ($conn->query($sql) as $row) 
			{
				echo "<option id='$row[usertypename]' value='$row[usertypename]'>$row[usertypename]</option>";
			}
		}
		else
		{
			$sql = "Select utid,usertypename from bp_usertype where utid != 1";
			foreach ($conn->query($sql) as $row) 
			{
				echo "<option id='$row[usertypename]' value='$row[usertypename]'>$row[usertypename]</option>";
			}
		}
		
		*/
		
		include('../dbconnection/dbconnection_close.php');

	?>