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
	
		<p style="color:#ffffff; font-size:20px; text-align:center; font-weight: bold; text-decoration:underline;">On-line Seat Reservation - Registration</p>
		 <form action="userdetails.php" method="post" onSubmit="return fnValidateMemberRegistrationForm(this);">
			<table width="100%" border="1" height="300"style=" font-size:12px;color:#ffffff; ">
				<tr>
					<td>
						<strong><font size="4">Full Name:</font></strong><br>
						<font size="2">(as per NRIC / Proof of Identity)</font></td>
					<td colspan="2">
						<strong>
							<input type="text" name="Fname" size="50" style="height:30px;">
						</strong>
					</td>
				</tr>
				<tr>
					<td>
						<strong><font size="4">Contact Telephone No: </font></strong>
						<br>
						<font size="2">(preferably a mobile phone number)</font></td>
					<td colspan="2">
						<strong>
							<input type="text" name="tel_mobile" size="50" style="height:30px;">
						</strong>
					</td>
				</tr>
				<tr>
					<td>
						<strong><font size="4">NRIC No: </font></strong>
						<br>
						<font size="2">(NRIC for Singapore citizens & PRs / FIN or Passport No. for others) <br />
							(<font color="red">You will have to produce your proof of identity<br> mentioned here to the auditorium for admission to the auditorium </font>)</font></td>
					<td colspan="2">
						<strong>
							<input type="text" name="ic_num" size="50" style="height:30px;">
						</strong>
					</td>
				</tr>
				<tr>
					<td>
						<strong><font size="4">Email ID: </font></strong>
					</td>
					<td colspan="2">
						<strong>
							<input type="text" name="emailID" size="50" style="height:30px;">
						</strong>
					</td>
				</tr>
			</table>
			<center>
				<input type="submit" value="Submit" style="margin-top: 30px; width:150px; height:30px;" />
			</center>
		</form>
	</div>
	</div>
  </body>
</html>