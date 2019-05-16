<?php 
	$add=App\Helper::checkAuthFunction(18,'add'); 
	$edit=App\Helper::checkAuthFunction(18,'edit'); 
	$delete=App\Helper::checkAuthFunction(18,'delete'); 

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
				Calibration
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
							<a href="{{URL::to('calibration/add/0/0')}}" ><button class="btn btn-primary mr5">Add New</button></a>
						</div>
						</div>
						@endif
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body">
					  <table class="customTable table table-bordered table-striped">
						<thead>
						  <tr>
							<th>Station ID</th>
							<th>ADC 50</th>
							<th>ADC 100</th>
							<th>M</th>
							<th>C</th>
							<th>ADC 50 Datetime</th>
							<th>ADC 100 Datetime</th>
						  </tr>
						</thead>
						<tbody>
							
							@foreach($calibration as $key=>$val)
								<tr>
									<td>{{$val->station_id}}</td>
									<td>{{$val->adc_50}}</td>
									<td>{{$val->adc_100}}</td>
									<td>{{$val->m}}</td>
									<td>{{$val->c}}</td>
									<td>{{$val->adc_50_datetime}}</td>
									<td>{{$val->adc_100_datetime}}</td>
									<?php /*
									<td>
										@if($edit)
										<a href="{{URL::to('station/status/'.$val->id)}}" title="Change Status" class="status btn @if($val->is_active==0){{'btn-success'}}@else{{'btn-danger'}}@endif">	
											@if($val->is_active==0){{'Active'}}@else{{'Inactive'}}@endif
										</a>
										@endif
									</td>
									<td>
										@if($edit)
										<a href="{{URL::to('station/edit/'.$val->id)}}" title="Edit"><i class="fa fa-edit editIcon"></i></a>
										@endif
										@if($delete)
											<a href="#click" onclick="deleteAssign({{$val->id}});" title="Delete" data-toggle="modal"><i class="fa fa-trash-o deleteIcon"></i></a>
										@endif
									</td>
									*/ ?>
								</tr>
							@endforeach
						</tbody>
					  </table>
					</div><!-- /.box-body -->
				  </div><!-- /.box -->
					 <?php /*
					<div id="click" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog">
						   <div class="modal-content">
							<form action="" method="post" class="cancel-order-form">
								<input type="hidden" name="cancel_order_session_id" class="cancel_order_session_id" />
								<div class="modal-header cancel">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
									<h4 class="modal-title">Delete Calibration</h4>
								</div>
								<div class="modal-body">
									<p class="cancel_order_text">Are you sure want to delete this Calibration? You cannot undo this action!</p>
								</div>
								<div class="modal-footer">
									<button type="button" data-dismiss="modal" class="btn default mr5">Cancel</button>
									<button type="button" class="btn btn-primary mr5 confirm">Confirm</button>
								</div>
							</form>
						   </div>
						</div>
					</div> */ ?>
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
	/* function deleteAssign(id){
		$('.confirm').attr('onclick','deleteRow('+id+')');
	}
	function deleteRow(id){
		window.location.href = "{{URL::to('station/delete')}}/"+id;
	} */
</script>

@endsection
