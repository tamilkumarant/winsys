	<?php
					
		include('../dbconnection/dbconnection_open.php');
		
		
			$query = "Select pid,project_id,project_name,project_description,project_status from bwl_project";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			echo '<table id="example1" class="table table-bordered table-striped">';
			echo "<thead>\n";
			echo "<tr>\n";
			
			echo "\t<th>ID</th>\n";
			echo "\t<th>Name</th>\n";
			echo "\t <th>Description</th>\n";
			echo "\t <th>Status</th>\n";
			echo "\t <th>Edit</th>\n";
			echo "\t <th>Delete</th>\n";
			echo "</tr>\n";
			echo "</thead>\n";
			echo "<tbody>\n";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			
			
			{
                echo "\t<tr>\n";
				echo "\t<td>".$row['project_id']."</td>\n";
				echo "\t<td>".$row['project_name']."</td>\n";
				echo "\t<td>".$row['project_description']."</td>\n";
				
				if($row['project_status'] == 1)
				{
					echo "\t<td><a href='../code_behind/project_status_change.php?pid=$row[pid]'><img src='../image/small_green.png' border='0' alt='Delete'></a></td>\n";
				}
				else
				{
					echo "\t<td><a href='../code_behind/project_status_change.php?pid=$row[pid]'><img src='../image/small_red.png' border='0' alt='Edit'></a></td>\n";
				}
				
				//echo "\t<td>".$row['project_status']."</td>\n";
				echo"\t<td><a href='../controllers/project_edit.php?pid=$row[pid]'><img src='../pub/dist/img/b_edit.gif' border='0' alt='Edit'></a></td>\n";
				echo"\t<td><a href='../code_behind/project_delete.php?pid=$row[pid]' onclick='return theFunction();' ><img src='../pub/dist/img/b_drop.gif' border='0' alt='Delete'></a></td>\n";
				echo "</tr>\n";
            }
			
		 
			echo "</tbody>\n";
			echo "</table>\n";
		
		include('../dbconnection/dbconnection_close.php');
	?>