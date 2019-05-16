	<?php
		//require "top_header/project_header.php"; // common header
		require "../top_header/project_header.php"; // top header
	?>
	<style>
		.p5{
			margin: 5px;
		}
	</style>
		<!-- Content Wrapper. Contains page content -->
		
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
		<?php 
			include('../dbconnection/dbconnection_open.php');
			if(checkAuth(5,'view')){ 
		?>
        <section class="content-header">
          <h1>
            Menu Access
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Default box -->
          
			<div class="box">
                <div class="box-header">
                  <h3 class="box-title">Menu Access</h3>
                </div><!-- /.box-header -->
                <div class="box-body">	
					<form action="../code_behind/menuaccess_action.php" method="post" onSubmit="return fnValidateprojectRegistrationForm(this);">				
					<div class="container" style="padding-top:10px;">
						<div class='col-md-offset-2 col-md-2'>
							<label>User Type :</label><label style="color:Red;">*</label>
						</div>
						<div class='col-md-4'>
							<select  name="usertype" class="form-control" onchange="userrolechange(this.value)" required>
								<option id="select_user_type" selected value="">[--Select User Type--]</option>
								<?php
									require "../code_behind/usertype_list.php"; // common header
									
								?>
							
							</select>
							
						</div>
						<div class='col-md-12 p5'>
							&nbsp;							
							<?php 
								
								require "../code_behind/menuaccess_display_list.php"; // common header
								include('../dbconnection/dbconnection_open.php');
								
								$role_id = isset($_GET['role_id'])?($_GET['role_id']):0;

							?>
						</div>
						<div class='col-md-11'>
							<table border=0 cellpadding=10 cellspacing=0 class="customTable table table-bordered table-striped dataTable no-footer" >
								<tr>
									<th>S.no</th>
									<th>Menu ID</th>
									<th>Menu</th>
									<th>View <i class="fa fa-desktop"></i></th>
									<th>Add <i class="fa fa-plus"></i></th>
									<th>Edit <i class="fa fa-edit"></i></th>
									<th>Delete <i class="fa fa-trash-o"></i></th>
								</tr>
								<?php foreach($data as $key=>$val) { 
									$check=checkListmenuaccess($role_id,$val['id']); 
									$view = ($check['view']==1)?('checked'):'';
									$add = ($check['add']==1)?('checked'):'';
									$edit = ($check['edit']==1)?('checked'):'';
									$delete = ($check['delete']==1)?('checked'):'';
								?>
								<tr>
									<td><?php echo $key+1; ?></td>
									<td><?php echo $val['id']; ?></td>
									<td><?php echo $val['menu']; ?></td>
									<td><input type="checkbox" name="view[]" class="view" value="<?php echo $val['id']; ?>" <?php echo $view; ?> ></td>
									<td><input type="checkbox" name="add[]" class="view" value="<?php echo $val['id']; ?>" <?php echo $add; ?> ></td>
									<td><input type="checkbox" name="edit[]" class="view" value="<?php echo $val['id']; ?>" <?php echo $edit; ?> ></td>
									<td><input type="checkbox" name="delete[]" class="view" value="<?php echo $val['id']; ?>" <?php echo $delete; ?> ></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<div class="container" style="padding-top:10px;">
							<div class='col-md-2'>
								<label></label>
							</div>
							<div class='col-md-offset-3 col-md-2'style="padding-top:10px;">
								<button type="submit" value="Submit"  style="width:100px;" class="btn btn-primary active">Save </button>
							</div>
						</div>
						<?php
							require "../code_behind/menuaccess_display_list.php"; // common header
						?>
					</div><!-- /.box-body -->
					</form>
				</div><!-- /.box -->
			</div><!-- /.content-wrapper -->
		</section><!-- /.content -->
		<?php } ?>
	</div>
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
	
	<script>
		$(function(){
			
			
		});
		function userrolechange(id){
			window.location.href = "menuaccess.php?role_id="+id;
		}
		
	</script>
  </body>
</html>