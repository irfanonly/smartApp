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
		{{--<li><a href="{{URL::to('/device')}}"><i class="fa fa-desktop"></i> DASHBOARD</a></li>--}}
		<li class="active"><i class="fa fa-calculator"></i> Calculator</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>Monthly Energy Consumption Calculator
					</strong></h1>
					<button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
					@if(session()->get('user_group')==1)
					@endif
				</div>
			</div>
			<div class="panel-body" >
				<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
				
				<div class="row">
					<table class="table">
						<thead>
							<tr>
								<th>Appliances</th>
								<th>Approx. load (watts)</th>
								<th>No of Appliances</th>
								<th>Avg usage Hours/Day</th>
								<th>Approx. units/month</th>
							</tr>
						</thead>
						<tbody>
							<form id="calculator-form">
								<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
								<?php
								$i = 0;
								?>

								@foreach($user_appliances as $key => $value)
								<?php
								$i++;
								?>	
								<tr id="td_{{$i}}">
									<td>{{$value->name}} <input type="hidden" name="id[]" value="{{$value->id}}"></td>
									<td class="watts">{{$value->appload}}</td>
									<td><input class="form-control input-sm no_of_app" type="number" name="no_of_app[]"></td>
									<td><input class="form-control input-sm usage_hrs" type="number" name="usage_hrs[]"></td>
									<td><input class= "form-control input-sm units_month" type="number" name="units_month[]" readonly="readonly"></td>
								</tr>

								@endforeach
							</form>

						</tbody>
					</table>

				</div>
				<div class="row div-margintop">
					<div class="col-md-6">
						<div class="form-group">
							<div class="col-md-offset-4 col-sm-8">
								<button type="button" class="btn btn-primary" onclick="calculateFormsubmit()">Calculate
								</button>
							</div>
						</div>
						
					</div>
					
				</div> <!--row-->
				<br/>
				<div class="row">
					<div class="col-md-6">
						<table class="table">
							
							<thead>
								<tr>
									<th colspan="4">Results</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Monthly Approximate Units:</td>
									<td id="mau" style="text-align: left;font-weight: 700;"></td>
									<td>Monthly Approximate Bill (Rs.):</td>
									<td id="mab" style="text-align: left;font-weight: 700;"></td>
								</tr>
							</tbody>
						</table>
					</div>
					
				</div> <!--row-->

			</div>
		</div><!-- panel -->
	</div>
	@foreach($js_files as $js_file)
	<script type="text/javascript" src="{{ $js_file}}"></script>

	@endforeach
	<script>
		$('#main_menu_calculator').addClass("active");
		function calculateFormsubmit(){
			if ($("#calculator-form").valid()) {
				$.ajax({
					type: 'post',
					url: base_url + '/calculator/calculate',
					cache: false,
					data: $('#calculator-form').serialize(),
					success: function (json) {
						$('#mau').text(json.totalunits);
						$('#mab').text(json.calculatebill.toFixed(2));
						//var result = jQuery.parseJSON(json);
						//if (json) {
						//	console.log(result);
						//	alert(result);
							//fillUserDetailsDataTable(result.data);
							//$('#myModal').modal('show');
							//var text = $('#id').val() != "" ? "Updated" : "Added";
							//$.gritter.add({
							//	title: 'Success',
							//	text: 'User ' + text + ' Successfully.',
							//	class_name: 'with-icon check-circle success'
							//});
						//}
					}
				});
			}
		}

		$('.no_of_app, .usage_hrs').change(function(){
			var tr = $(this).parents('tr') ;
			var no_of_app = $(tr).find('.no_of_app').val(); 
			var watts = parseInt($(tr).find('.watts').text());
			var usage = $(tr).find('.usage_hrs').val();
			if(usage == '' || usage == null || no_of_app == '' || no_of_app == null){
				$(tr).find('.units_month').val('');
			}else{
				var units = watts * usage * 30 / 1000 ;
				$(tr).find('.units_month').val(Math.round(units));
			}
		});
		
		
		$('.datepicker').datepicker({
			orientation:"bottom left"
		});

		function close_btn(){
			window.location.href = base_url + '/home';
		}
	</script>
	@endsection
