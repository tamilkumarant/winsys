	<?php
		include('../dbconnection/dbconnection_open.php');
		
		$usertype=$_REQUEST['usertype'];
	
		
		$success='';
		$view=isset($_REQUEST['view'])?($_REQUEST['view']):'';
		$add=isset($_REQUEST['add'])?($_REQUEST['add']):'';
		$edit=isset($_REQUEST['edit'])?($_REQUEST['edit']):'';
		$delete=isset($_REQUEST['delete'])?($_REQUEST['delete']):'';
		
		$query = "UPDATE menu_access SET menu_access.view=0,menu_access.add=0,menu_access.edit=0,menu_access.delete=0 WHERE role_id={$usertype}"; 
		$stmt = $conn->prepare($query);
		$stmt->execute();
				
		if(is_array($view)){
			foreach($view as $key=>$val){
			
				$menuaccessid=0;
				$query = "SELECT id FROM menu_access WHERE menu_id=$val AND role_id=$usertype";
				foreach ($conn->query($query) as $row) 
				{
					$menuaccessid =  $row['id'];
				}
				if($menuaccessid>0){
						$query = "UPDATE menu_access SET menu_access.view=1 WHERE id={$menuaccessid}"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}else{
						$query = "INSERT INTO menu_access (role_id,menu_id,view) VALUES('$usertype','$val','1')"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}
				$success=1;
			}
		} 		
		if(is_array($add)){
			foreach($add as $key=>$val){
			
				$menuaccessid=0;
				$query = "SELECT id FROM menu_access WHERE menu_id=$val AND role_id=$usertype";
				foreach ($conn->query($query) as $row) 
				{
					$menuaccessid =  $row['id'];
				}
				if($menuaccessid>0){
						$query = "UPDATE menu_access SET menu_access.add=1 WHERE id={$menuaccessid}"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}else{
						$query = "INSERT INTO menu_access (role_id,menu_id,menu_access.add) VALUES('$usertype','$val','1')";  
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}
				$success=1;
			}
		} 		
		if(is_array($edit)){
			foreach($edit as $key=>$val){
			
				$menuaccessid=0;
				$query = "SELECT id FROM menu_access WHERE menu_id=$val AND role_id=$usertype";
				foreach ($conn->query($query) as $row) 
				{
					$menuaccessid =  $row['id'];
				}
				if($menuaccessid>0){
						$query = "UPDATE menu_access SET menu_access.edit=1 WHERE id={$menuaccessid}"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}else{
						$query = "INSERT INTO menu_access (role_id,menu_id,menu_access.edit) VALUES('$usertype','$val','1')"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}
				$success=1;
			}
		} 
		if(is_array($delete)){
			foreach($delete as $key=>$val){
			
				$menuaccessid=0;
				$query = "SELECT id FROM menu_access WHERE menu_id=$val AND role_id=$usertype";
				foreach ($conn->query($query) as $row) 
				{
					$menuaccessid =  $row['id'];
				}
				if($menuaccessid>0){
						$query = "UPDATE menu_access SET menu_access.delete=1 WHERE id={$menuaccessid}"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}else{
						$query = "INSERT INTO menu_access (role_id,menu_id,menu_access.delete) VALUES('$usertype','$val','1')"; 
						$stmt = $conn->prepare($query);
						$stmt->execute();
				}
				$success=1;
			}
		}

		
		include('../dbconnection/dbconnection_close.php');
		header("Location: ../controllers/menuaccess.php?role_id=".$usertype);
		
		exit(0);
	?>
          