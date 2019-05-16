@extends('admin.layout')

@section('css')
<style>

</style>

@endsection

@section('content')
		
        <!-- Content Header (Page header) -->
			
        <section class="content-header">	
			<h1>
				Users
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-edit"></i> Edit User</a></li>	
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
							<h3 class="box-title">Edit User</h3>
						</div>
						
						<form role="form" class="validate" method="post" action="">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-12">						  
								<div class="col-md-6">						  
									<div class="box-body">
										<div class="form-group">
											<label for="name">Name</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="name" name="name" placeholder="Name"  value="{{$users->name}}" required/>
										</div>
									</div>				  
									<div class="box-body">
										<div class="form-group">
											<label for="username">Username</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="username" name="username" placeholder="Username"  value="{{$users->username}}" required/>
										</div>
									</div>			  
									<div class="box-body">
										<div class="form-group">
											<label for="mobile">Mobile</label><span class="required_star">*</span>
											<input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile"  value="{{$users->mobile}}" required/>
										</div>
									</div>		  
									<div class="box-body">
										<div class="form-group">
											<label for="email">E-mail</label><span class="required_star">*</span>
											<input type="email" class="form-control" id="email" name="email" placeholder="E-mail"  value="{{$users->email}}" required/>
										</div>
									</div>		
								</div>		
								<div class="col-md-6">										
									<div class="box-body">
										<div class="form-group">
											<label for="password_text">Password</label><span class="required_star">*</span>
											<input type="text" class="form-control" id="password_text" name="password_text" placeholder="Password" value="{{$users->password_text}}" required/>
										</div>
									</div>
									<div class="form-group">								
										<label for="user_role"> User Role</label><span class="required_star">*</span>
										<select name="user_role" class="form-control user_role" required >
											<option value="">Select User Role</option>
											@foreach($roles as $key=>$val)
												<option value="{{$val->id}}" @if($users && $users->user_role==$val->id){{'selected'}} @endif  >{{$val->name}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group">
										<label>Project<span class="required_star">*</span></label>
										<select class="form-control project" name="project_id" data-placeholder="Select a Project" style="width: 100%;" required onchange="getStations(this.value)">
											<option value="">Select</option>
											@foreach($project as $key=>$val)
												<option value="{{$val->id}}" @if($users && $users->project_id==$val->id){{'selected'}} @endif  >{{$val->project_name}}</option>
											@endforeach
										</select>
										<div><label for="project" generated="true" class="error"></label></div>
									</div>
									<div class="form-group">
										<label>Stations<span class="required_star">*</span></label>
										<select class="form-control select2 station" multiple="multiple" name="station[]" data-placeholder="Select a Stations" style="width: 100%;" required data-value="1,2">
											@foreach($station as $key=>$val)
												<option value="{{$val->id}}" >{{$val->station_name}}</option>
											@endforeach
										</select>
										<div><label for="station[]" generated="true" class="error"></label></div>
									</div>
								</div>
							</div>
							<div class="box-footer ">
								<div class="col-md-offset-5 col-md-4">
									<button type="submit" class="btn btn-primary">Submit</button>								
									<a href="{{URL::to('user')}}" class="btn btn-default">Back</a>
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
	var stationList = <?php echo json_encode($stationList); ?>;
	$(document).ready(function () {
		$('.validate').validate();
		$(".select2").select2();
		$('.select2').val(stationList);
		$(".select2").trigger('change');
		/* var id = $('.project').val();
		if($id){
			getStations(id);
		} */
	});
	
	function getStations(id){
		
		var url = "{{url('get-stations')}}/"+id;
		$.getJSON(url, function(result){ 
			$('.station').html("");
			$('.station').select2({
			  data: result
			});
			$('.station').select2().trigger('change');	
		});
	}
</script>

@endsection

