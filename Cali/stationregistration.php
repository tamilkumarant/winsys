
	
	
	

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Station Calibration
          </h1>
         
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
           
            <div class="box-body">
			
			<form action="station_calibration100.php" method="post" onSubmit="return fnValidateMemberRegistrationForm(this);">
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Station ID 123:</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                        <select  name="projectname" class="form-control">
						<option selected value="Select Project Name">[--Select Station ID--]</option>
							<?php
								include('dbconnection_open.php');
								
								
									$result = mysql_query( "SELECT station_id FROM bwl_station where  is_active = 0" )
									or die("SELECT Error: ".mysql_error());
									$num_rows = mysql_num_rows($result);
									
									while ($get_info = mysql_fetch_row($result))
									{
										echo "<option>$get_info[0]</option>";
									}
								
								include('dbconnection_close.php');
								
								echo "Abhilash";
							?>
						</select>
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
						   <div class='col-md-2'>
								<label></label>
						  </div>
						  <div class='col-md-2'style="padding-top:10px;">
							  <button type="submit" value="Submit"  style="width:100px;" class="btn btn-primary active">Save </button>
						  </div>
						  <div class='col-md-2'style="padding-top:10px;">
							  <a href="station.php"><button type="button" style="width:100px;" class="btn btn-primary active">Cancel</button></a>
						  </div>
					</div>
			</form>
		    </div><!-- /.box-body -->
            <div class="box-footer">
              
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

	<?php
		require "include/footer.php"; // common header
	?>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>