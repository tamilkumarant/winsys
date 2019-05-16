<?php
//open connection to mysql db
	$con = mysql_connect('localhost', 'root','root123');
	if (!$con) {
		die('Error: Failed to connect to member database. ErrCode: ' . mysql_error());
	} // end if
	mysql_select_db("bg", $con);
?>