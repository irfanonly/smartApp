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
.rounded-circle {
    border-radius: 50%!important;
}
.mb-4{
	height: 300px;
}
</style>
<div class="contentpanel" style="overflow-x: hidden;">
	<ol class="breadcrumb breadcrumb-quirk">
		<li class="active"><i class="fa fa-users"></i> About Us</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>About Us
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
				
				<br/>
				<div class="container">

      <!-- Introduction Row -->
      <h1 class="my-4">About Us
        <small>It's Nice to Meet You!</small>
      </h1>
     <!--  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint, explicabo dolores ipsam aliquam inventore corrupti eveniet quisquam quod totam laudantium repudiandae obcaecati ea consectetur debitis velit facere nisi expedita vel?</p>

      <!-- Team Members Row -->
      <div class="row">
        <div class="col-lg-12">
          <h2 class="my-4">Our Team</h2>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <img class="rounded-circle img-fluid d-block mx-auto" src="/smart-app/public/images/aboutus/Udantha.jpg" alt="">
          <h3>Udantha Thenuwara
            <small>UdanthaChandhimal@gmail.com</small>
          </h3>
          <p>

B.Sc(Hons) in Information Technology (Spec) Computer System and Network Engineering</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <img class="rounded-circle img-fluid d-block mx-auto" src="/smart-app/public/images/aboutus/anu.jpg" alt="">
          <h3>Rukshana Rafeek
            <small>Anu.rukshana@gmail.com</small>
          </h3>
          <p>

B.Sc(Hons) in Information Technology (Spec) Information Technology</p>
        </div>
        <div class="col-lg-4 col-sm-6 text-center mb-4">
          <img class="rounded-circle img-fluid d-block mx-auto" src="/smart-app/public/images/aboutus/Damith.jpg" alt="">
          <h3>Damith Dananjaya

            <small>damithdananjaya4@gmail.com</small>
          </h3>
          <p>

B.Sc(Hons) in Information Technology (Spec) Computer System and Network Engineering</p>
        </div>
       <div class="col-lg-4 col-sm-6 text-center mb-4">
          <img class="rounded-circle img-fluid d-block mx-auto" src="/smart-app/public/images/aboutus/Shankavi.jpg" alt="">
          <h3>Shankavi Rajan

            <small>Shankavi3.st@gmail.com</small>
          </h3>
          <p>

B.Sc(Hons) in Information Technology (Spec) Information Technology</p>
        </div>
       
       
      </div>

    </div>

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
			window.location.href = base_url + '/home';
		}
	</script>
	@endsection
