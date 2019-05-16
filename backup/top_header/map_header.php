	<?php
		$session_expiration = time() + 3600 * 24 * 2; // +2 days
		session_set_cookie_params($session_expiration);
		session_start();
	?>
	<?php
		if(isset($_SESSION['username']))
			{
				$username = $_SESSION['username'];
			}
		else
		{
		}
		
		if(isset($_SESSION['password']))
		{
		   $password = $_SESSION['password'];
		   // echo "$password";
		}
		else
		{
		}
		
		require "../include/header.php"; // common header
		include('../dbconnection/dbconnection_open.php');
		
		$sql = "SELECT utid,uid FROM bwl_user where  user_name = '$username' and user_password = '$password'";
		foreach ($conn->query($sql) as $row) 
		{
            $utid =  $row['utid'];
			$uid =  $row['uid'] ;
        }
		
		if($utid == 1)
		{
			require "../include/leftNavmap.html"; // left navigation
		}
		else
		{
			require "../include/leftNavmap.html"; // normal user - left navigation
		}
		include('../dbconnection/dbconnection_close.php');
		
	?>