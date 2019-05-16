@extends('admin.layout')

@section('css')
<style>

</style>

@endsection

@section('content')
		
		
        <!-- Content Header (Page header) -->
			
        <section class="content-header">	
			<h1>
				Menu Access
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
					  <!-- general form elements -->
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title">Menu Access</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					<form role="form" class="validate" method="post" action="">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="col-md-12 no-padding">
						
					<div class="box">
					<div class="box-header">
					</div><!-- /.box-header -->
					<div class="box-body">
						<div class="col-md-4 col-md-offset-4 no-padding">
							<div class="form-group">
								<label for="country">User Role</label><span class="required_star">*</span>
								<select name="user_role" class="form-control user_role" required onchange="changeRole(this.value);">
									<option value="">Select Role</option>
									@foreach($roles as $key=>$val)
										<option value="{{$val->id}}" @if($role_id==$val->id){{'selected'}} @endif  >{{$val->name}}</option>
									@endforeach
								</select>
							</div>
						</div><!-- /.box-body -->
					<div class="box-body">
					  <table class="customTable table table-bordered table-striped">
						<thead>
						  <tr>
							<th>S.No</th>
							<th>Menu ID</th>
							<th>Menu</th>
							<th>View <i class="fa fa-desktop"></i></th>
							<th>Add <i class="fa fa-plus"></i></th>
							<th>Edit <i class="fa fa-edit"></i></th>
							<th>Delete <i class="fa fa-trash-o deleteIcon"></i></th>
						  </tr>
						</thead>
						<tbody>
							
							@foreach($menu as $key=>$val)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$val->id}}</td>
									<td>{{$val->menu}}</td>
									<td><input type="checkbox" name="view[]" class="view" value="{{$val->id}}" @if($val->view==1) {{'checked'}} @endif /></td>
									<td><input type="checkbox" name="add[]" class="add" value="{{$val->id}}" @if($val->add==1) {{'checked'}} @endif /></td>
									<td><input type="checkbox" name="edit[]" class="edit" value="{{$val->id}}"  @if($val->edit==1) {{'checked'}} @endif/></td>
									<td><input type="checkbox" name="delete[]" class="delete" value="{{$val->id}}" @if($val->delete==1) {{'checked'}} @endif /></td>
								</tr>
							@endforeach
						</tbody>
					  </table>
					</div><!-- /.box-body -->
				  <div class="box-footer ">
					<div class="col-md-offset-5 col-md-4">
						<button type="submit" class="btn btn-primary">Submit</button>								
						<button type="reset" class="btn btn-default">Reset</button>	
					</div>
				  </div>				  
				  </div><!-- /.box -->
				</form>
					  
				
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
	function changeRole(id){
		if(id){
			window.location.href = "{{URL::to('menu-access/')}}/"+id;
		}
	}
</script>

@endsection
