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
.table > tfoot > tr > th{
	height: 31px;
	padding-top: 5px;
	padding-bottom: 5px;
}
</style>
<div class="contentpanel" style="overflow-x: hidden;">
	<ol class="breadcrumb breadcrumb-quirk">
		{{--<li><a href="{{URL::to('/device')}}"><i class="fa fa-bold"></i> DASHBOARD</a></li>--}}
		<li class="active"><i class="fa fa-bold"></i> Budget</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>Budget
					</strong></h1>
					<button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
					@if(session()->get('user_group')==1)
					@endif
				</div>
			</div>
			<div class="panel-body" >
				<form id="formInput">
					<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">

					<div class="row div-margintop">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Select Home :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<select name="home" id="home" class="form-control" required>
											@foreach($user_home as $key => $value)
											<option value="{{$value->id}}">{{$value->name}}</option>
											@endforeach
										</select>

									</div>
								</div>
							</div>
							
						</div>
					</div> <!--row-->



					<div class="row div-margintop">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Last Metering Date :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<input type="text" name="lastmeteringdate" id="lastmeteringdate" data-placeholder="Users" class="form-control datepicker" required />


									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Next Metering Date :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<input type="text" data-placeholder="Users" name="nextmeteringdate" id="nextmeteringdate" class="form-control datepicker" required />


									</div>
								</div>
							</div>
						</div>
					</div> <!--row-->
					<div class="row div-margintop">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Your Budget :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<input type="text" name="budget" id="budget" data-placeholder="Users" class="form-control" required />


									</div>
								</div>
							</div>

						</div>
					</div> <!--row-->
					<div class="row div-margintop">
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-offset-4 col-sm-8">
									<button type="button" class="btn btn-primary" onclick="userFormsubmit()">Report
									</button>
								</div>
							</div>

						</div>

					</div> <!--row-->
				</form>
				
				

			</div>
		</div><!-- panel -->
	</div>
	<div class="modal bounceIn animated" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" id="estimate-unit">
				
			</div><!-- modal-content -->
		</div><!-- modal-dialog -->
	</div><!-- modal -->
	@foreach($js_files as $js_file)
	<script type="text/javascript" src="{{ $js_file}}"></script>

	@endforeach
	<script>
		$('#main_menu_budget').addClass('active');
		$('.datepicker').datepicker({
			orientation:"bottom left"
		});

		$('#formInput').validate({

			rules: {
				home:{
					required: true,
				},
				budget: {
					required: true,
					//remote: {
					//	url: base_url+"/login/user_validation",
					//	type: "get",
					//	data: {
					//		user_name: function () {
					//			return $("#user_name").val();
					//		}
					//	}
					//}
				},
				lastmeteringdate:{
					required: true,
				},
				nextmeteringdate:{
					required: true,
				},

				//user_name: {
				//	required: true,
				//	remote: {
				//		url: base_url+"/login/check_username",
				//		type: "get",

				//	}
				//}
			},
			messages: {
				//password: {
				//	remote: "Incorrect Password"
				//},
				//user_name: {
				//	remote: "Invalid username"
				//}
			},
			highlight: function (element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function (element) {
				$(element).closest('.form-group').removeClass('has-error');
			}
		});

		function userFormsubmit() {
			if ($("#formInput").valid()) {
				$.ajax({
					type: 'post',
					url: base_url + '/budget/report',
					cache: false,
					data: $('#formInput').serialize(),
					success: function (json) {
						//alert(json);
						var result = jQuery.parseJSON(json);
						//if (result) {
								//fillUserDetailsDataTable(result.data);
							$('#estimate-unit').empty();
							$('#myModal').modal('show');
							$('#estimate-unit').html(result);
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

		function saveEstimateUsage(){
			$.ajax({
					type: 'post',
					url: base_url + '/budget/save-report',
					cache: false,
					data: $('#formReport').serialize(),
					success: function (json) {
						//alert(json);
						//var result = jQuery.parseJSON(json);
						//if (result) {
								//fillUserDetailsDataTable(result.data);
							$('#estimate-unit').empty();
							$('#myModal').modal('hide');
							$('#formInput').trigger("reset");
							//$('#estimate-unit').html(result);
								//var text = $('#id').val() != "" ? "Updated" : "Added";
								$.gritter.add({
									title: 'Success',
									text: 'Records Updated Successfully.',
									class_name: 'with-icon check-circle success'
								});
						//}
					}
				});
		}

		function regenerateEstimateUsage(){
			if($('input[name="is_reduce[]"]:checked').length <= 0){
				$.gritter.add({
                                    title: 'Validation Error',
                                    text: 'Please choose atleast a device',
                                    class_name: 'with-icon check-circle danger'
                                });
			}else{
				$.ajax({
					type: 'post',
					url: base_url + '/budget/regenerate',
					cache: false,
					data: $('#formReport').serialize(),
					success: function (json) {
						//alert(json);
						var result = jQuery.parseJSON(json);
						//if (result) {
								//fillUserDetailsDataTable(result.data);
							$('#estimate-unit').empty();
							$('#myModal').modal('show');
							$('#estimate-unit').html(result);
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

		function close_btn(){
			window.location.href = base_url + '/main';
		}
	</script>
	@endsection
