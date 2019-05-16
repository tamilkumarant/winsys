	<?php
		require "../top_header/project_header.php"; // top header
	?>
	<!-- add project validation -->
	<script src="../jscript/projectValidation.js"></script>
	
	<!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Menu
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
              <h3 class="box-title">Menu</h3>
            </div>
            <div class="box-body">
			<form action="../code_behind/menu_action.php" method="post" onSubmit="return fnValidateprojectRegistrationForm(this);">
			
				<div class="container" style="padding-top:10px;">
                    <div class='col-md-2'>
                        <label>Menu:</label>
                    </div>
                    <div class='col-md-4'>
                        <input type="text" class="form-control" name="menu" required>
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
                      <a href="menu.php"><button type="button" style="width:100px;" class="btn btn-primary active">Cancel</button></a>
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