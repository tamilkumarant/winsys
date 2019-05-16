<?Php
	
	include('../dbconnection/dbconnection_open.php');
	
	$data = array();
	
	$query = "select id,menu from menu";
	$stmt = $conn->prepare($query);
	$stmt->execute();
	
	$data =	array();
	
	while($row = $stmt->fetch(PDO::FETCH_ASSOC))
	{
		$data[] = array('id'=>$row['id'],'menu'=>$row['menu']);		
	}
	
	if($data){
	
			echo '<table id="example1" class="table table-bordered table-striped">';
			echo "<thead>\n";
			echo "<tr>\n";
			
			echo "\t<th>ID</th>\n";
			echo "\t<th>Menu</th>\n";
			echo "\t <th>Edit</th>\n";
			echo "\t <th>Delete</th>\n";
			echo "</tr>\n";
			echo "</thead>\n";
			echo "<tbody>\n";
			foreach($data as $val){
                echo "\t<tr>\n";
				echo "\t<td>".$val['id']."</td>\n";
				echo "\t<td>".$val['menu']."</td>\n";
				
				echo"\t<td><a href='../controllers/menu_edit.php?id=$val[id]'><img src='../pub/dist/img/b_edit.gif' border='0' alt='Edit'></a></td>\n";
				echo"\t<td><a href='../code_behind/menu_delete.php?id=$val[id]' onclick='return theFunction();' ><img src='../pub/dist/img/b_drop.gif' border='0' alt='Delete'></a></td>\n";
				echo "</tr>\n";
            }
			
		 
			echo "</tbody>\n";
			echo "</table>\n";
	}
	
	
	
	include('../dbconnection/dbconnection_close.php');
?>