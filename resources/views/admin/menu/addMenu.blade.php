@extends('admin.layout')

@section('css')
<style>

</style>

@endsection

@section('content')
		
        <!-- Content Header (Page header) -->
			
        <section class="content-header">	
			<h1>
				Menu
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-edit"></i> Add Menu</a></li>	
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
				
				  <!-- general form elements -->
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">Add Menu</h3>
						</div><!-- /.box-header -->
						<!-- form start -->
						<form role="form" class="validate" method="post" action="">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="col-md-6 col-md-offset-3">						  
						  <div class="box-body">
							<div class="form-group">
								<label for="country">Menu</label><span class="required_star">*</span>
									<input type="text" class="form-control" id="menu" name="menu" placeholder="Menu" required/>
							</div>
						  </div><!-- /.box-body -->
							<div class="box-body">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="is_active" id="is_active" class="is_active" value="1"   /> Is Active
									</label>
								</div>
							</div>
						</div>
						  <div class="box-footer ">
							<div class="col-md-offset-5 col-md-4">
								<button type="submit" class="btn btn-primary">Submit</button>								
								<a href="{{URL::to('menu')}}" class="btn btn-default">Back</a>
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

