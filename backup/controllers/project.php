	<?php
		//require "top_header/project_header.php"; // common header
		require "../top_header/project_header.php"; // top header
	?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
		<?php 
			include('../dbconnection/dbconnection_open.php');
			if(checkAuth(1,'view')){ 
		?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Projects
          </h1>
          <ol class="breadcrumb">
            <li><a href="project_registration.php"><i class="fa fa-plus"></i> Add new project</a></li>
		  </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          
          <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Project details</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
					<?php
						require "../code_behind/project_display_list.php"; // common header
					?>
				</div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
			<?php } ?>
      </div><!-- /.content-wrapper -->
	<?php
		require "../include/footer.php"; // common footer
	?>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../pub/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../pub/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../pub/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../pub/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="../pub/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../pub/dist/js/app.min.js" type="text/javascript"></script>
	<!-- page script -->
	<script src="../jscript/table_query.js"></script>
	<!-- delete user -->
	<script src="../jscript/project_delete.js"></script>
  </body>
</html>