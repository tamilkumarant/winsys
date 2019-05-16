<?php 

	function checkListmenuaccess($role_id,$menu_id){
		global $conn; 
		$query = "SELECT a.view,a.add,a.edit,a.delete FROM menu_access a WHERE role_id = '$role_id' AND menu_id = '$menu_id'";
		$stmt = $conn->prepare($query);
		$stmt->execute();
		
		$data=array();		
		$data['view'] = 0;
		$data['add'] = 0;
		$data['edit'] = 0;
		$data['delete'] = 0;
		
		while($row = $stmt->fetch())
		{
			$data['view'] = ($row['view']>0)?1:0;
			$data['add'] = ($row['add']>0)?1:0;
			$data['edit'] = ($row['edit']>0)?1:0;
			$data['delete'] = ($row['delete']>0)?1:0;
		}
		return $data;
	}
	
	function checkAuth($id,$field) { 
		global $conn; 
		$role_id='';
		if($_SESSION['userrole']>0){
			$role_id=$_SESSION['userrole'];
		}		
		if($role_id){
			$menuaccessid = null;
			$query = "SELECT id FROM menu_access WHERE $field=1 AND role_id=$role_id AND menu_id=$id";
			foreach ($conn->query($query) as $row) 
			{
				$menuaccessid =  $row['id'];
			}
			return $menuaccessid;
		}else{
			return null;
		}
	}
	function p($array,$exit=true){
		
		echo '<pre>';
		print_r($array);
		echo '</pre>';
		if($exit){
			exit;
		}
		
	}


?>