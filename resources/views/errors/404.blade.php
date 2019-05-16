<?php 
	$link='';
	$user_role=isset(Auth::User()->user_role)?Auth::User()->user_role:0;
	if($user_role){ $link='dashboard'; }
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
            404 Error Page
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{URL::to($link)}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">404 error</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
              <p>
                We could not find the page you were looking for.
                Meanwhile, you may <a href="{{URL::to($link)}}">return to dashboard</a>
              </p>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section><!-- /.content -->
       
        

@endsection

@section('js')

	<script>
		@if(!$link)
			window.location.href="{{URL::to('auth/logout')}}";
		@endif
	</script>

@endsection

