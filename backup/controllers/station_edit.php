	<?php
		require "../top_header/project_header.php"; // top header
	?>
	
	<!-- add user validation -->
	<script src="../jscript/stationValidation.js"></script>
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit station
          </h1>
          <ol class="breadcrumb">
           <li></li>
           </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Station Information</h3>
            </div>
            <div class="box-body">
			<form action="../code_behind/stationedit_action.php" method="post" onSubmit="return fnValidatestationRegistrationForm(this);">
				<?php
					require "../code_behind/station_edit_list.php"; // common header
				?>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Station ID:</label>
                    </div>
                    <div class='col-md-4'>
                         <input type="text" class="form-control" name="stationid" value= "<?php echo $row_array['stationid']; ?>" >
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Station Name :</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationname" value= "<?php echo $row_array['stationname']; ?>" >
                    </div>
				</div>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Latitude:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationLatitude" value= "<?php echo $row_array['stationLatitude']; ?>" >
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Longitude:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationLongitude" value= "<?php echo $row_array['stationLongitude']; ?>" >
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
					<div class='col-md-2'>
						<label>Project Name :</label><label style="color:Red;">*</label>
					</div>
					<div class='col-md-4'>
						<select  name="projectname" class="form-control" >
					<option selected value="<?php echo $projectname; ?>"><?php echo $projectname; ?></option>
						<?php
							require "../code_behind/project_list.php"; // common header
						?>
					</select>
					</div>
				</div>
				
				
				<input type='hidden' class="input-field" name='stid' value='<?php echo $row_array['stid']; ?>'>
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
		require "../include/footer.php"; // common footer
	?>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../pub/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../pub/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="../pub/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../pub/dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>