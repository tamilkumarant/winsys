	<?php
					
		include('../dbconnection/dbconnection_open.php');
		
		
			$query = "Select stid,station_id,station_name,station_latitude,station_longitude,station_status from bwl_station";
			$stmt = $conn->prepare($query);
			$stmt->execute();
			
			echo '<table id="example1" class="table table-bordered table-striped">';
			echo "<thead>\n";
			echo "<tr>\n";
			
			echo "\t<th>ID</th>\n";
			echo "\t<th>Name</th>\n";
			echo "\t <th>Latitude</th>\n";
			echo "\t <th>Longitude</th>\n";
			echo "\t <th>Status</th>\n";
			echo "\t <th>Edit</th>\n";
			echo "\t <th>Delete</th>\n";
			echo "</tr>\n";
			echo "</thead>\n";
			echo "<tbody>\n";
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			
			
			{
                echo "\t<tr>\n";
				echo "\t<td>".$row['station_id']."</td>\n";
				echo "\t<td>".$row['station_name']."</td>\n";
				echo "\t<td>".$row['station_latitude']."</td>\n";
				echo "\t<td>".$row['station_longitude']."</td>\n";
				
				if($row['station_status'] == 1)
				{
					echo "\t<td><a href='../code_behind/station_status_change.php?stid=$row[stid]'><img src='../image/small_green.png' border='0' alt='Delete'></a></td>\n";
				}
				else
				{
					echo "\t<td><a href='../code_behind/station_status_change.php?stid=$row[stid]'><img src='../image/small_red.png' border='0' alt='Edit'></a></td>\n";
				}
				
				//echo "\t<td>".$row['project_status']."</td>\n";
				echo"\t<td><a href='../controllers/station_edit.php?stid=$row[stid]'><img src='../pub/dist/img/b_edit.gif' border='0' alt='Edit'></a></td>\n";
				echo"\t<td><a href='../code_behind/station_delete.php?stid=$row[stid]' onclick='return theFunction();' ><img src='../pub/dist/img/b_drop.gif' border='0' alt='Delete'></a></td>\n";
				echo "</tr>\n";
            }
			
		 
			echo "</tbody>\n";
			echo "</table>\n";
		
		include('../dbconnection/dbconnection_close.php');
	?>