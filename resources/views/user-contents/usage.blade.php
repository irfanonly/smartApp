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


</style>
<div class="contentpanel" style="overflow-x: hidden;">
	<ol class="breadcrumb breadcrumb-quirk">
		{{--<li><a href="{{URL::to('/device')}}"><i class="fa fa-history"></i> USAGE</a></li>--}}
		<li class="active"><i class="fa fa-history"></i> Usage</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>Usage History
					</strong></h1>
					<button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
					@if(session()->get('user_group')==1)
					@endif
				</div>
			</div>
			<div class="panel-body" >
				<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
				
				<div class="row">
					<div class="col-md-6">
						<table class="table">
							
							<thead>
								<tr>

									<th colspan="2">Current Usage 
									</th>
								</tr>
							</thead>
							<tbody>
								@foreach($current_usage as $key=>$value)
								<?php 
								$v = json_encode($value[0]);
								$d = json_decode($v) ;
								$used = round((($d->consump) / ($d->budget_units) ) * 100) ;
								$progress = 'progress-bar-success';
								if($used > 99){
									$progress ='progress-bar-danger';
								} 
								?>
								<tr>
									<td width="10">{{ $d->HomeName.' ('.$d->last_billing_date.'-'.$d->next_billing_date.')' }}</td>
									<td width="90">
										<div class="progress">
											<div class="progress-bar {{$progress}}" role="progressbar" 		aria-valuenow="{{$used}}"
											aria-valuemin="0" aria-valuemax="100" style="padding-left: 3px; text-align:left;width:{{$used}}%">
											{{$used}}% Used
										</div>
									</td>
								</tr>
								@endforeach

							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						
						<form id="graph-form">
							<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
							<div class="col-md-2">
								<label class="col-sm-12 control-label text-left" for="select_device">Year : </label>
								<input type="text" name="datepicker" id="datepicker" class="form-control" />
							</div>
							<div class="col-sm-8 text-center">
								<label class="label label-success">Monthly Unit Usage</label>
							</div>
							<div class="col-md-12">
								<div id="area-chart" style="height: 200px">
								</div>
							</div>

						</form>
					</div>

				</div> <!--row-->

				<div class="row">

					<div class="col-md-12">
						<form id="search-form">
							<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
							<div class="col-md-3">
								<label class="col-sm-12 control-label text-left" for="select_home">Select Home  : </label>
								<div class="col-sm-12">
									<select name="home" id="home" class="form-control">
										@foreach($user_home as $key => $value)
										<option value="{{$value->id}}">{{$value->name}}</option>
										@endforeach
									</select>

								</div>

							</div>
							<div class="col-md-2">
								<label class="col-sm-12 control-label text-left" for="select_home">From  : </label>
								<div class="col-sm-12">
									<input type="text" name="fromdate" id="fromdate" data-placeholder="Users" class="form-control datepicker" required />

								</div>
								
							</div>
							<div class="col-md-2">
								<label class="col-sm-12 control-label text-left" for="select_home">To  : 
								</label>
								<div class="col-sm-12">
									<input type="text" name="todate" id="todate" data-placeholder="Users" class="form-control datepicker" required />

								</div>
								
							</div>
							

							<div class="col-md-2">
								<label class="col-sm-12 control-label text-left" for="select_home">&nbsp;;
								</label>
								<div class="col-sm-12">
									<button type="button" class="btn btn-primary" onclick="retriveSubmit()">Retrieve
									</button>
								</div>
							</div>

						</form>
					</div>

					

				</div>

				<div class="row" id="usage_table">

				</div>

				<br/>


			</div>
		</div><!-- panel -->
	</div>
	@foreach($js_files as $js_file)
	<script type="text/javascript" src="{{ $js_file}}"></script>

	@endforeach
	<script>
		$('#main_menu_usage').addClass('active');
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




		$('#datepicker').datepicker({
			orientation:"bottom left",
			format: "yyyy",
			viewMode: "years", 
			minViewMode: "years",

		});
		$("#datepicker").datepicker("setDate", new Date);

		$('#datepicker').change(function(){
			//alert('a');
			$('#area-chart').html('');
			updateGraph($(this).val());
		});
		updateGraph($('#datepicker').val());
		var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

		function retriveSubmit(){

			$.ajax({
				type: 'post',
				url: base_url + '/usage/retrive-data',
				cache: false,
				data: $('#search-form').serialize(),
				success: function (json) {
					//alert(json);
					var result = jQuery.parseJSON(json);
					$('#usage_table').empty();
					$('#usage_table').append(result);
					$('html, body').animate({
						scrollTop: ($('#usage_table').first().offset().top - 200)
					},2);
					

				}
			});
		}

		function updateGraph(year){

			$.ajax({
				type: 'post',
				url: base_url + '/usage/get-graph',
				cache: false,
				data: $('#graph-form').serialize(),
				success: function (json) {
					//alert(json)

					//var data = '{ "y": "2018-1", "a": 50}' ;
					
					config = {
						data: JSON.parse(json),  // '['+jQuery.parseJSON(json) + ']',
						xkey: 'y',
						ykeys: ['a'],
						xLabels:"month",
						labels: ['Units Usage'],
						fillOpacity: 0.6,
						hideHover: 'auto',
						behaveLikeLine: true,
						resize: true,
						xLabelFormat: function(x){ return months[(new Date(x)).getMonth()]},
						pointFillColors:['#ffffff'],
						pointStrokeColors: ['black'],
						lineColors:['gray'],
						element: 'graph',
					};
					config.element = 'area-chart';
					Morris.Area(config);

				}
			});
		}

		function close_btn(){
			window.location.href = base_url + '/home';
		}

		$('.datepicker').datepicker({
			//orientation:"top left"
		});


	</script>
	@endsection
