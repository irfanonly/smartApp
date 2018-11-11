@extends('admin-layouts.main')
@section('headers')
<title>SmartApp | User</title>
@foreach($css_files as $css_file)
<link rel="stylesheet" type="text/css" id="theme" href="{{ $css_file}}"/>
@endforeach
@endsection
@section('content')
<style type="text/css">
.div-margintop{
	margin-top: 10px;
}
.form-control[readonly]{
	color: #262b36;
}
</style>
<div class="contentpanel" style="overflow-x: hidden;">
	<ol class="breadcrumb breadcrumb-quirk">
		<li class="active"><i class="fa fa-leanpub"></i> User Guide</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>User Guide
					</strong></h1>
					<button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
					@if(session()->get('user_group')==1)
					@endif
				</div>
			</div>
			<div class="panel-body" >
				<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
				
				<div class="row">
					

				</div>
				<div class="row div-margintop">
					<div class="col-md-6">
						<div class="form-group">
							<div class="col-md-offset-4 col-sm-8">
								
							</div>
						</div>
						
					</div>
					
				</div> <!--row-->
				<br/>
				<div class="row">
					<div class="col-md-6">
						
					</div>
					
				</div> <!--row-->

			</div>
		</div><!-- panel -->
	</div>
	@foreach($js_files as $js_file)
	<script type="text/javascript" src="{{ $js_file}}"></script>

	@endforeach
	<script>
		$('#main_menu_user_guide').addClass('active');
		$('.datepicker').datepicker({
			orientation:"bottom left"
		});

		function close_btn(){
			window.location.href = base_url + '/main';
		}
	</script>
	@endsection
