	<?php
		require "../top_header/station_header.php"; // top header
	?>
	<!-- add station validation -->
	<script src="../jscript/stationValidation.js"></script>
	
	<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new station
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
              <h3 class="box-title">Station information</h3>
            </div>
            <div class="box-body">
			<form action="../code_behind/stationreg_action.php" method="post" onSubmit="return fnValidatestationRegistrationForm(this);">
			
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Station ID:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationid">
                    </div>
				</div>
			
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Station Name:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationname">
                    </div>
				</div>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Latitude:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationLatitude">
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Longitude:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="stationLongitude">
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Project Name :</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                        <select  name="projectname" class="form-control">
						<option selected value="0">[--Select Project Name--]</option>
						
							<?php
								require "../code_behind/project_list.php"; // common header
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
    <script src='../pub/plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../pub/dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>