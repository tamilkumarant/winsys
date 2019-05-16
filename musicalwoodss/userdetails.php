<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta charset="UTF-8">
    <title>musicalwoods - Tickets</title>
  </head>
<body style="background-color:#0e111e; ">
	
	<div style="border:solid 0px red; width:1000px; margin-right:auto; margin-left:auto; ">
	<?php
		require "include/header.php"; // common header
	?>
	
	<div style="border:solid 0px red; float:left; width:100%; color:#ffffff;">
	
		 <?php
		 
			$con = mysql_connect('localhost', 'root','root123');
			if (!$con) {
				die('Error: Failed to connect to member database. ErrCode: ' . mysql_error());
			} // end if
			mysql_select_db("musicalwoods", $con);
			$Fname=$_POST['Fname'];
			$tel_mobile=$_POST['tel_mobile'];
			$emailID=$_POST['emailID'];
			$ic_num=$_POST['ic_num'];
			
			echo $emailID;
			
			
			//$sqlmemEmailnum = "SELECT * FROM user WHERE `email` = '$emailID' ";
			//$resultmemEamilnum = mysql_query($sqlmemEmailnum, $con) OR die ($sqlmemEmailnum . mysql_error());
			//$countmemEmailnum= mysql_num_rows($resultmemEamilnum);

		 
		 ?>
		 <p> aaaa</p>
											
	</div>
	</div>
  </body>
</html>