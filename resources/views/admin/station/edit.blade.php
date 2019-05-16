<?php 
use App\Models\Station;

	$typeArray = Station::$typeArray;

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
				Station
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-edit"></i> Edit Station</a></li>	
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
							<h3 class="box-title">Edit Station</h3>
						</div>
						
						<form role="form" class="validate" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-12">						  
								<div class="col-md-4">						  
									<div class="box-body">
										<div class="form-group">
											<label for="station_id">Station ID</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="station_id" name="station_id" placeholder="Station ID" value="{{$station->station_id}}" required/>
										</div>
									</div>	

									<div class="box-body">
										<div class="form-group">
											<label for="location">Station Location</label><span class="required_star">*</span>
											<input type="text" class="form-control location" id="location" name="location" placeholder="Station Location" value="{{$station->location}}" />
										</div>
									</div>										  
									<div class="box-body">
										<div class="form-group">
											<label for="pub_id">PUB ID</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="pub_id" name="pub_id" placeholder="PUB ID" value="{{$station->pub_id}}" required/>
										</div>
									</div>				  
									<div class="box-body">
										<div class="form-group">
											<label for="station_name">Station Name</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="station_name" name="station_name" placeholder="Station Name" value="{{$station->station_name}}" required/>
										</div>
									</div>			  
									<div class="box-body">
										<div class="form-group">
											<label for="station_latitude">Station Latitude</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="station_latitude" name="station_latitude" placeholder="Station Latitude" value="{{$station->station_latitude}}" required/>
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="station_longitude">Station Longitude</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="station_longitude" name="station_longitude" placeholder="Station Longitude" value="{{$station->station_longitude}}" required/>
										</div>
									</div>
									<div class="form-group">								
										<label for="project_id"> Project ID</label><span class="required_star">*</span>
										<select name="project_id" class="form-control project_id" required >
											<option value="">Select Project ID</option>
											@foreach($projects as $key=>$val)
												<option value="{{$val->id}}"  @if($station && $station->project_id==$val->id){{'selected'}} @endif  >{{$val->project_name}}</option>
											@endforeach
										</select>
									</div>		
									<div class="box-body">
										<div class="form-group">
											<label for="offset_o">Station Offset</label><span class="required_star">*</span>
											<input type="number" class="form-control offset_o" id="offset_o" name="offset_o" placeholder="Station Offset" value="{{$station->offset_o}}" />
										</div>
									</div>		
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="calibration_m">Station M</label><span class="required_star"></span>
											<input type="number" class="form-control" id="calibration_m" name="calibration_m" placeholder="Station M"  value="{{$station->calibration_m}}"/>
										</div>
									</div>	
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="spike_threshold">Spike Threshold</label><span class="required_star"></span>
											<input type="number" class="form-control" id="spike_threshold" name="spike_threshold" placeholder="Spike Threshold"  value="{{$station->spike_threshold}}"/>
										</div>
									</div>	

									<div class="box-body">
										<div class="form-group">
											<label for="image">Station Image</label><span class="required_star">*</span>
											<input type="file" class="form-control image" id="image" name="image" placeholder="Station Image" />
										</div>
										@if($station->image)
											{{$station->image}}
										@endif
									</div>	

									<div class="form-group">								
										<label for="type"> Type</label><span class="required_star">*</span>
										<select name="type" class="form-control type" required >
											<option value="">Select Type</option>
											@foreach($typeArray as $key=>$val)
												<option value="{{$key}}" @if($station && $station->type==$key){{'selected'}} @endif >{{$val}}</option>
											@endforeach
										</select>
									</div>   
									<div class="box-body">
										<label for="project_id"> Manintenance</label><span class="required_star"></span>
										<div class="form-group">
											<div class="col-md-3">		
												<div class="radio">
													<label>
													  <input type="radio" name="maintenance" id="maintenance1" value="1" @if($station && $station->maintenance==1){{'checked'}}@endif  >
													  True
													</label>
												</div>
											</div>
											<div class="col-md-3">		
												<div class="radio">
													<label>
													  <input type="radio" name="maintenance" id="maintenance2" value="0"  @if($station && $station->maintenance==0){{'checked'}}@endif >
														False
													</label>
												</div>
											</div>
										</div>
									</div>	
								</div>								
								<div class="col-md-4">	
									<div class="box-body">
										<div class="form-group">
											<label for="copelevel">Station Cope Level</label><span class="required_star">*</span>
											<input type="number" class="form-control copelevel" id="copelevel" name="copelevel" placeholder="Station ID" required value="{{$station->copelevel}}" />
										</div>
									</div>				  
									<div class="box-body">
										<div class="form-group">
											<label for="invertlevel">Station Invert Level</label><span class="required_star">*</span>
											<input type="number" class="form-control invertlevel" id="invertlevel" name="invertlevel" placeholder="Station Name" required onblur="setOffset()"   value="{{$station->invertlevel}}"  />
										</div>
									</div>			  
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="height">Station Height</label><span class="required_star">*</span>
											<input type="number" class="form-control height" id="height" name="height" placeholder="Station Height" required readonly  value="{{$station->height}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="operationlevel">Station operation level</label><span class="required_star">*</span>
											<input type="number" class="form-control operationlevel" id="operationlevel" name="operationlevel" placeholder="Station operation level" required value="{{$station->operationlevel}}" onblur="setOffset()" />
										</div>
									</div>		  
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="criticallevel">Station critical level</label><span class="required_star">*</span>
											<input type="number" class="form-control criticallevel" id="criticallevel" name="criticallevel" placeholder="Station critical level" required value="{{$station->criticallevel}}"  />
										</div>
									</div>
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="calibration_c">Station C</label><span class="required_star"></span>
											<input type="number" class="form-control calibration_c" id="calibration_c" name="calibration_c" placeholder="Station C" value="{{$station->calibration_c}}"  />
										</div>
									</div>		  
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="delta">Delta</label><span class="required_star"></span>
											<input type="number" class="form-control delta" id="delta" name="delta" placeholder="Delta" value="{{$station->delta}}"  />
										</div>
									</div>		  
									<div class="box-body displaynone">
										<div class="form-group">
											<label for="alarmlevel">Alarmlevel</label><span class="required_star"></span>
											<input type="number" class="form-control alarmlevel" id="alarmlevel" name="alarmlevel" placeholder="Delta" value="{{$station->alarmlevel}}"  />
										</div>
									</div>	 	  	  
									<div class="box-body">
										<div class="form-group">
											<label for="b1">B1</label><span class="required_star">*</span>
											<input type="number" class="form-control b1" id="b1" name="b1" placeholder="B1" required value="{{$station->b1}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="b2">B2</label><span class="required_star">*</span>
											<input type="number" class="form-control b2" id="b2" name="b2" placeholder="B2" required value="{{$station->b2}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="b3">B3</label><span class="required_star">*</span>
											<input type="number" class="form-control b3" id="b3" name="b3" placeholder="B3" required value="{{$station->b3}}"  />
										</div>
									</div>	  
									<div class="box-body">
										<div class="form-group">
											<label for="b4">B4</label><span class="required_star">*</span>
											<input type="number" class="form-control b4" id="b4" name="b4" placeholder="B4" required value="{{$station->b4}}"  />
										</div>
									</div>	  
									<div class="box-body">
										<div class="form-group">
											<label for="b5">B5</label><span class="required_star">*</span>
											<input type="number" class="form-control b5" id="b5" name="b5" placeholder="B5" required value="{{$station->b5}}"  />
										</div>
									</div>	 
								</div>

								<div class="col-md-4">			  
									<div class="box-body">
										<div class="form-group">
											<label for="h1">H1</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="h1" name="h1" placeholder="H1" required value="{{$station->h1}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="h2">H2</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="h2" name="h2" placeholder="H2" required value="{{$station->h2}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="h3">H3</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="h3" name="h3" placeholder="H3" required value="{{$station->h3}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="h4">H4</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="h4" name="h4" placeholder="H4" required value="{{$station->h4}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="h5">H5</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="h5" name="h5" placeholder="H5" required value="{{$station->h5}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="w1">W1</label><span class="required_star">*</span>
											<input type="number" class="form-control w1" id="w1" name="w1" placeholder="W1" required value="{{$station->w1}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="w2">W2</label><span class="required_star">*</span>
											<input type="number" class="form-control w2" id="w2" name="w2" placeholder="W2" required value="{{$station->w2}}"  />
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="w3">W3</label><span class="required_star">*</span>
											<input type="number" class="form-control w3" id="w3" name="w3" placeholder="W3" required value="{{$station->w3}}"  />
										</div>
									</div>	  
									<div class="box-body">
										<div class="form-group">
											<label for="w4">W4</label><span class="required_star">*</span>
											<input type="number" class="form-control w4" id="w4" name="w4" placeholder="W4" required value="{{$station->w4}}"  />
										</div>
									</div>	  
									<div class="box-body">
										<div class="form-group">
											<label for="w5">W5</label><span class="required_star">*</span>
											<input type="number" class="form-control w5" id="w5" name="w5" placeholder="W5" required value="{{$station->w5}}"  />
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-md-offset-3">		
								<div class="box-footer ">
									<div class="col-md-offset-5 col-md-4">
										<button type="submit" class="btn btn-primary">Submit</button>								
										<a href="{{URL::to('station')}}" class="btn btn-default">Back</a>
									</div>
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
			rules: {
				invertlevel: {
					required: true,
					max: function() {
						return parseFloat($('.copelevel').val() || 0);
					}
				}
			}
		});
				
	});

	function setOffset(){ 
		/*var operationlevel = $('.operationlevel').val() || 0;
		var invertlevel = $('.invertlevel').val() || 0;
		operationlevel = parseFloat(operationlevel);
		invertlevel = parseFloat(invertlevel);
		// console.log(operationlevel);console.log(invertlevel);console.log((operationlevel-invertlevel));
		if(operationlevel>0 && invertlevel>0 && (operationlevel-invertlevel)>0){
			$('.offset_o').val((operationlevel-invertlevel).toFixed(3));
		}*/
	}
</script>

@endsection

