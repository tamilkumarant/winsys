	<?php
		require "../top_header/user_header.php"; // top header
	?>
	<!-- add station validation -->
	<script src="../jscript/userValidation.js"></script>
	<script src="../jscript/userTypeSelection.js"></script>
	<script src="../jscript/stationselection.js"></script>
	
	<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new user
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
              <h3 class="box-title">User information</h3>
            </div>
            <div class="box-body">
			<form name="testform" id="testform" action="../code_behind/userreg_action.php" method="post" onSubmit="return fnValidateuserRegistrationForm(this);">
			
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Name:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="name">
                    </div>
				</div>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>User Name:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="username">
                    </div>
				</div>
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Password:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="userpassword">
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Phone:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="userphone">
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Email:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="useremail">
                    </div>
				</div>
				
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>User Type :</label><label style="color:Red;">*</label>
                    </div>
                    <div class='col-md-4'>
                       <select  name="usertype" class="form-control" onchange="usertypeselection()">
						<option id="select_user_type" selected value="0">[--Select User Type--]</option>
						
							<?php
								require "../code_behind/usertype_list.php"; // common header
							?>
						
						</select>
                    </div>
				</div>
				
				<div id="projectadmin_form" class="" style="display: none;">
				
					<div class="container" style="padding-top:10px;">
						<div class='col-md-2'>
							<label>Project Name :</label><label style="color:Red;">*</label>
						</div>
						<div class='col-md-4'>
						   <select  name="projectname" class="form-control">
							<option id="select_project_name" selected value="0">[--Select Project Name--]</option>
							
								<?php
									require "../code_behind/project_list.php"; // common header
								?>
							
							</select>
						</div>
					</div>
				
				</div>
				
				<div id="normaluser_form" class="" style="display: none;">
				
					<div class="container" style="padding-top:10px;">
						<div class='col-md-2'>
							<label>Project Name :</label><label style="color:Red;">*</label>
						</div>
						<div class='col-md-4'>
						   <select  name="projectname" id="projectname" class="form-control" onchange="stationselection()">
							<option id="select_project_name" selected value="0">[--Select Project Name--]</option>
							
								<?php
									require "../code_behind/project_list.php"; // common header
								?>
							
							</select>
						</div>
					</div>
					
					
					
					
					<div class="container" style="padding-top:10px;">
						<div class='col-md-2'>
							<label>Station List :</label><label style="color:Red;">*</label>
						</div>
						<div class='col-md-4'>
						   <select  name="stationname" id="stationname" class="form-control" size=4 multiple>
								
								
							</select>
						</div>
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
                      <a href="user.php"><button type="button" style="width:100px;" class="btn btn-primary active">Cancel</button></a>
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