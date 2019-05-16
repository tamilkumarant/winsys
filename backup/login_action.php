<?php
	session_start();
	
	include('dbconnection/dbconnection_open.php');

	$username=$_POST['username'];
	$password=$_POST['password'];
		
	$sql = "SELECT * FROM bwl_user WHERE user_name = '$username' and user_password = '$password'";
	
	if ($res = $conn->query($sql)) 
	{
		if ($res->fetchColumn() == 0) 
		{
			header("Location: ../index.php");
			exit(0); 
		}
		else
		{
			$user_role=0;
			foreach ($conn->query($sql) as $row) 
			{
				$user_role =  $row['user_role'];
			}			
			$_SESSION['userrole'] = $user_role;
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			header("Location: ../controllers/map.php");
			exit(0); 
		}
	}

	include('dbconnection/dbconnection_close.php');	
	
?>