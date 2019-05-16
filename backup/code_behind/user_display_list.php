	<?php
					
		include('../dbconnection/dbconnection_open.php');
		
		
			$query = "Select uid,name,user_name,user_password,utid,user_status from bwl_user";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			echo '<table id="example1" class="table table-bordered table-striped">';
			echo "<thead>\n";
			echo "<tr>\n";
			echo "\t<th>Name</th>\n";
			echo "\t<th>User Name</th>\n";
			echo "\t <th>Password</th>\n";
			echo "\t <th>User Type</th>\n";
			echo "\t <th>Status</th>\n";
			echo "\t <th>Edit</th>\n";
			echo "\t <th>Delete</th>\n";
			echo "</tr>\n";
			echo "</thead>\n";
			echo "<tbody>\n";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			
			
			{
                echo "\t<tr>\n";
				echo "\t<td>".$row['name']."</td>\n";
				echo "\t<td>".$row['user_name']."</td>\n";
				echo "\t<td>".$row['user_password']."</td>\n";
				
				
				if($row['utid'] == 1)
				{
					echo "\t<td>Administrator</td>\n";
				}
				elseif($row['utid'] == 2)
				{
					echo "\t<td>Project Admin</td>\n";
				}
				
				elseif($row['utid'] == 3)
				{
					echo "\t<td>Normal User</td>\n";
				}
				elseif($row['utid'] == 4)
				{
					echo "\t<td>Maintenance User</td>\n";
				}

				
				
				if($row['user_status'] == 1)
				{
					echo "\t<td><a href='../code_behind/user_status_change.php?uid=$row[uid]'><img src='../image/small_green.png' border='0' alt='Delete'></a></td>\n";
				}
				else
				{
					echo "\t<td><a href='../code_behind/user_status_change.php?uid=$row[uid]'><img src='../image/small_red.png' border='0' alt='Edit'></a></td>\n";
				}
				
				//echo "\t<td>".$row['project_status']."</td>\n";
				echo"\t<td><a href='../controllers/user_edit.php?uid=$row[uid]'><img src='../pub/dist/img/b_edit.gif' border='0' alt='Edit'></a></td>\n";
				echo"\t<td><a href='../code_behind/user_delete.php?uid=$row[uid]' onclick='return theFunction();' ><img src='../pub/dist/img/b_drop.gif' border='0' alt='Delete'></a></td>\n";
				echo "</tr>\n";
            }
			
		 
			echo "</tbody>\n";
			echo "</table>\n";
		
		include('../dbconnection/dbconnection_close.php');
	?>