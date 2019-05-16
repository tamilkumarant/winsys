	  <?php
	 
		include('dbconnection_open.php');
		
		$sql_role_id = "SELECT bp_user_role.role_id as 'role_id', bp_user.uid as 'user_id' from bp_user_role JOIN bp_user on bp_user.uid = bp_user_role.user_id where  bp_user.username = '$username' and bp_user.password = '$password'";
		$role_id_new = mysql_query($sql_role_id) or die(mysql_error());
		$role_id_row = mysql_fetch_array($role_id_new);
		$role_id = $role_id_row['role_id'];
		$user_id = $role_id_row['user_id'];
		
		include('dbconnection_close.php');

		if($role_id == 1)
		{
			include('include/leftNav.html');
		}
		else
		{
			include('include/localleftNav.html');
		}
	?>