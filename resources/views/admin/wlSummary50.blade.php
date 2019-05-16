
@extends('admin.layoutwlsummary')

@section('css')
<style>
	.size16{
		font-size:20px;
		font-weight:700;
	}
</style>

@endsection

@section('content')
		
		
        <!-- Content Header (Page header) -->
			
        <section class="content-header">	
			<h1>
				WL (summary > 50%)
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
						
						<div class="box-header">
						</div><!-- /.box-header -->
						<div class="box-body">
							<form action="" method="post" id="summary50Form" >
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								<div class="col-md-2 text-right">
									<label>Date and time range:</label>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-clock-o"></i>
											</div>
											<input type="text" class="form-control pull-right daterange" id="daterange" name="daterange" value="{{$daterange}}" readonly>
										</div>
									</div>
								</div>
								<div class="col-md-2 ">
									<input type="submit" name="submit" class="btn btn-success" value="Show Data"  />
								</div>
								<div class="col-md-1 no-padding mtop10 txtright">
									<span>Status</span>
								</div>	
								<div class="col-md-3 no-padding mtop5">
									<select name="status" class="form-control status" required  onchange="SubmitForm(this.value);" >
										<option value="1" @if($status==1){{'selected'}}@endif >All</option>
										<option value="3" @if($status==3){{'selected'}}@endif>Above 50%</option>
										<option value="4" @if($status==4){{'selected'}}@endif>Above 75%</option>
										<option value="5" @if($status==5){{'selected'}}@endif>Above 90%</option>
										<option value="6" @if($status==6){{'selected'}}@endif>100%</option>
										
									</select>
								</div>	
							</form>
						</div>
						
						<div class="box-header">
						</div><!-- /.box-header -->
						<div class="box-body">
						  <table class="customTable table table-bordered table-striped">
							<thead>
							  <tr>
								<th>S.No</th>
								<th>Station ID</th>
								<th>Station Name</th>
								<th>Datetime</th>
								<th>Summary Data</th>
							  </tr>
							</thead>
							<tbody>
								
								@foreach($stations as $key=>$val)
									<tr>
										<td>{{$key+1}}</td>
										<td>{{$val['station_id']}}</td>
										<td>{{$val['station_name']}}</td>
										<td>{{date('d-m-Y H:i',strtotime($val['datetime']))}}</td>
										<td class="">{{$val['status']}}</td>
									</tr>
								@endforeach
							</tbody>
						  </table>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
					  
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
		
		$('#daterange').daterangepicker({
			timePicker: true, 
			timePickerIncrement: 1, 
			format: 'YYYY/MM/DD HH:mm',
		});
		
	});
</script>

@endsection
