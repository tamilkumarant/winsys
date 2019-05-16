	<?php
		include('../dbconnection/dbconnection_open.php');
		
		$menu=$_POST['menu'];
		
		
		$sql = "SELECT * FROM menu WHERE menu = '$menu'";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() == 0) 
			{
				$query = "INSERT INTO menu (menu) VALUES ('$menu')";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
			else
			{
				echo "<script>alert('Menu already exists. Enter another Menu');window.location=''</script>";
				header("Location: ../controllers/menu_registration.php");
			}
		}
		include('../dbconnection/dbconnection_close.php');
		header("Location: ../controllers/menu.php");
		
		exit(0);
	?>
          