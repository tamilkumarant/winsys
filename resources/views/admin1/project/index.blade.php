<?php 
	$add=App\Helper::checkAuthFunction(2,'add'); 
	$edit=App\Helper::checkAuthFunction(2,'edit'); 
	$delete=App\Helper::checkAuthFunction(2,'delete'); 

?>
@extends('admin.layout')

@section('css')
<style>

</style>

@endsection

@section('content')
		
		
        <!-- Content Header (Page header) -->
			
        <section class="content-header">	
			<h1>
				Project
			</h1>
			<ol class="breadcrumb">
				
			</ol>
        </section>
		<section class="content">
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">	
				
					@if(Session::has('success_msg'))
					<div class="box callout callout-success">
						<div class="box-header ">
							{{Session::get('success_msg')}}
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
					</div><!-- /.box -->	
					@endif
					@if(Session::has('error_msg'))
					<div class="box callout callout-danger">
						<div class="box-header ">
							{{Session::get('error_msg')}}
							<div class="box-tools pull-right">
								<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
							</div>
						</div>
					</div><!-- /.box -->	
					@endif
					
						
					<div class="box">
						@if($add)
						<div class="box-header">
						<div class="col-md-2 top2">	
							<a href="{{URL::to('project/add')}}" ><button class="btn btn-primary mr5">Add New</button></a>
						</div>
						</div>
						@endif
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body">
					  <table class="customTable table table-bordered table-striped">
						<thead>
						  <tr>
							<th>S.No</th>
							<th>Project ID</th>
							<th>Project Name</th>
							<th>Project<br/> Description</th>
							<th>Status</th>
							<th>Action</th>
						  </tr>
						</thead>
						<tbody>
							
							@foreach($project as $key=>$val)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$val->project_id}}</td>
									<td>{{$val->project_name}}</td>
									<td>{{$val->project_description}}</td>
									<td>
										@if($edit)
										<a href="{{URL::to('project/status/'.$val->id)}}" title="Change Status" class="status btn @if($val->is_active==0){{'btn-success'}}@else{{'btn-danger'}}@endif">	
											@if($val->is_active==0){{'Active'}}@else{{'Inactive'}}@endif
										</a>
										@endif
									</td>
									<td>
										@if($edit)
										<a href="{{URL::to('project/edit/'.$val->id)}}" title="Edit"><i class="fa fa-edit editIcon"></i></a>
										@endif
										@if($delete)
											<a href="#click" onclick="deleteAssign({{$val->id}});" title="Delete" data-toggle="modal"><i class="fa fa-trash-o deleteIcon"></i></a>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					  </table>
					</div><!-- /.box-body -->
				  </div><!-- /.box -->
					  
					<div id="click" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog">
						   <div class="modal-content">
							<form action="" method="post" class="cancel-order-form">
								<input type="hidden" name="cancel_order_session_id" class="cancel_order_session_id" />
								<div class="modal-header cancel">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete Project</h4>
								</div>
								<div class="modal-body">
									<p class="cancel_order_text">Are you sure want to delete this Project? You cannot undo this action!</p>
								</div>
								<div class="modal-footer">
									<button type="button" data-dismiss="modal" class="btn default mr5">Cancel</button>
									<button type="button" class="btn btn-primary mr5 confirm">Confirm</button>
								</div>
							</form>
						   </div>
						</div>
					</div>
				</div>
			</div>
		</section>


        <!-- Main content -->
        

@endsection

@section('js')

<script>
	$(document).ready(function () {
		
        $('.customTable').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
		  "sorting":[],
          "info": true,
          "autoWidth": false
        });
		
	});
	function deleteAssign(id){
		$('.confirm').attr('onclick','deleteRow('+id+')');
	}
	function deleteRow(id){
		window.location.href = "{{URL::to('project/delete')}}/"+id;
	}
</script>

@endsection
