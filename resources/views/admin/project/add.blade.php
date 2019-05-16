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
				<li class="active"><i class="fa fa-edit"></i> Add Project</a></li>	
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
							<h3 class="box-title">Add Project</h3>
						</div>
						
						<form role="form" class="validate" method="post" action="">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="col-md-6 col-md-offset-3">						  
								<div class="box-body">
									<div class="form-group">
										<label for="project_id">Project ID</label><span class="required_star">*</span>
										<input type="text" class="form-control" id="project_id" name="project_id" placeholder="Project ID" required/>
									</div>
								</div>				  
								<div class="box-body">
									<div class="form-group">
										<label for="project_name">Project Name</label><span class="required_star">*</span>
										<input type="text" class="form-control" id="project_name" name="project_name" placeholder="Project Name" required/>
									</div>
								</div>			  
								<div class="box-body">
									<div class="form-group">
										<label for="project_description">Project Description</label><span class="required_star">*</span>
										<input type="text" class="form-control" id="project_description" name="project_description" placeholder="Project Description" required/>
									</div>
								</div>
							</div>
							<div class="box-footer ">
								<div class="col-md-offset-5 col-md-4">
									<button type="submit" class="btn btn-primary">Submit</button>								
									<a href="{{URL::to('project')}}" class="btn btn-default">Back</a>
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
		$('.validate').validate();
	});
</script>

@endsection

