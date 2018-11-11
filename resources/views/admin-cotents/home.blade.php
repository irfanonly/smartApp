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
		<li class="active"><i class="fa fa-home"></i> Home</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="/smart-app/public/images/cr1 (1).jpg" alt="Los Angeles" style="width:100%;height: 480px">
      </div>

      <div class="item">
        <img src="/smart-app/public/images/cr1 (2).jpg" alt="Chicago" style="width:100%;height: 480px">
        <div class="carousel-caption">
        <h1 style="color: #520c0c;
    background-color: #5f861f;
    opacity: 0.9;">Our Vision</h1>
        <h2 style="color: #520c0c;
    background-color: #5f861f;
    opacity: 0.9;">Enjoy being the light for lives of people through innovative eco-friendly Environment and reduce the unwanted electricity usage.</h2>
      </div>
      </div>
    
      <div class="item">
        <img src="/smart-app/public/images/cr1 (5).jpg" alt="New york" style="width:100%;height: 480px">
        <div class="carousel-caption">
        <h1 style="color: #0e0e0e;
    background-color: #887c6c;
    opacity: 0.9;">Our Mission</h1>
        <h2 style="color: #0e0e0e;
    background-color: #887c6c;
    opacity: 0.9;">To provide the best energy solutions to the society through continuous innovations and save the energy for the future generation’s use.</h2>
      </div>
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

		</div><!-- panel -->
	</div>
	@foreach($js_files as $js_file)
	<script type="text/javascript" src="{{ $js_file}}"></script>

	@endforeach
	<script>
		$('#main_menu_home').addClass('active');
		
		

		
		
		
		$('.datepicker').datepicker({
			orientation:"bottom left"
		});

		function close_btn(){
			window.location.href = base_url + '/home';
		}
	</script>
	@endsection
