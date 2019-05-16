<?php 
	$adctext = 'ADC Value - 100cm';
	if($id==0){
		$adctext = 'ADC Value - 50cm';
	} 
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
				<li class="active"><i class="fa fa-edit"></i> Add Calibration</a></li>	
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
					</div>
					@endif
				
				  <!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Add Calibration</h3>
						</div>
						
						<form role="form" class="validate" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-12">						  
								<div class="col-md-6 col-md-offset-3">
									<div class="box-body">
										<select name="station_id" class="form-control station_id" required onchange="selectStation(this.value);" @if($id>0) disabled @endif >
											<option value="">Select Station</option>
											@foreach($stations as $key=>$val)
											<option value="{{$val->station_id}}" @if($selected_station==$val->station_id){{'selected'}}@endif  >{{$val->station_id.' '.$val->station_name}}</option>
											@endforeach
										</select>	  
									</div>
									<div class="box-body col-md-12">
										<button type="submit" class="btn btn-default col-md-6 col-md-offset-3" name="getlatest" value="0">
											Get Laster {{$adctext}}
										</button>		
									</div>	
									<div class="box-body col-md-12">
										<label>Datetime: {{$datetime}}</label>		
										<input type="hidden" name="datetime" value="{{$datetime}}" />
									</div>		  
									<div class="box-body col-md-12">
										<label>{{$adctext}}: {{$rawValue}}</label>		
										<input type="hidden" name="adc" value="{{$rawValue}}" />
									</div>		  
									<div class="box-body col-md-12">
										<label>Waterlevel Meter: {{$waterlevel_meter}}</label>											
									</div>		  
								</div>
							</div>
							<div class="box-footer ">
								<div class="col-md-offset-5 col-md-4">
									<button type="submit" class="btn btn-primary" name="submit" value="1">Submit</button>								
									<a href="{{URL::to('calibration')}}" class="btn btn-default">Back</a>
								</div>
							</div>
						</form>
					</div><!-- /.box -->
				</div>
			</div>
		</section>


        <!-- Main content -->
        

@endsection

@section('js')

<script>
	$(document).ready(function () {
		$('.validate').validate({
			
				
	});

</script>

@endsection

