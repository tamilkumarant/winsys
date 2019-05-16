	  <?php
	
		include('../dbconnection/dbconnection_open.php');
		
		$id = $_REQUEST['id'];
		$menu=$_POST['menu'];
		
		$sql = "SELECT *  FROM menu WHERE id <> $id AND menu='$menu'";
		if ($res = $conn->query($sql)) 
		{
			if ($res->fetchColumn() >= 1) 
			{
				echo "Menu already exists. Enter another Menu";
			}
			else
			{
				$query = "UPDATE menu SET  menu = '$menu' where id = $id";
				$stmt = $conn->prepare($query);
				$stmt->execute();
			}
		}
		
		include('../dbconnection/dbconnection_close.php');
		
		header("Location: ../controllers/menu.php");
		exit(0);
	?>
            