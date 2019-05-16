	<?php
		require "../top_header/project_header.php"; // top header
	?>
	
	<!-- add user validation -->
	<script src="../jscript/projectEditValidation.js"></script>
	  <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit project
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
              <h3 class="box-title">Project Information</h3>
            </div>
            <div class="box-body">
			<form action="../code_behind/projectedit_action.php" method="post" onSubmit="return fnValidateprojectEditForm(this);">
				<?php
					require "../code_behind/project_edit_list.php"; // common header
				?>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Project Name :</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="projectname" value= "<?php echo $row_array['projectname']; ?>" >
                    </div>
				</div>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Project Description :</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="projectdescription" value= "<?php echo $row_array['projectdescription']; ?>" >
                    </div>
				</div>
				<input type='hidden' class="input-field" name='pid' value='<?php echo $row_array['pid']; ?>'>
				<div class="container" style="padding-top:10px;">
                   <div class='col-md-2'>
                        <label></label>
                  </div>
                  <div class='col-md-2'style="padding-top:10px;">
                      <button type="submit" value="Submit"  style="width:100px;" class="btn btn-primary active">Save </button>
                  </div>
                  <div class='col-md-2'style="padding-top:10px;">
                      <a href="project.php"><button type="button" style="width:100px;" class="btn btn-primary active">Cancel</button></a>
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
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>