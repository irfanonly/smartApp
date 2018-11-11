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
		<li class="active"><i class="fa fa-question-circle"></i> Help</li>
	</ol>
	<div class="panel">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<h1 class="panel-title col-md-10"><strong>Help
					</strong></h1>
					<button onclick="close_btn()"  class="pull-right close-btn"><i class="fa fa-times" aria-hidden="true"></i> </button>
					@if(session()->get('user_group')==1)
					@endif
				</div>
			</div>
			<div class="panel-body" >
				<form id="help-form">
					<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">

					<div class="row div-margintop">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Subject :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<input type="text" name="subject" id="subject" data-placeholder="Users" class="form-control" required />

									</div>
								</div>
							</div>
							
						</div>
					</div> <!--row-->
					<div class="row div-margintop">
						<div class="col-md-12">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-sm-4 control-label text-left">Message :
										<span
										class="text-danger">*</span>
									</label>
									<div class="col-sm-8">
										<textarea required rows="10" class="form-control" id="message" name="message"></textarea>
										

									</div>
								</div>
							</div>
							
						</div>
					</div> <!--row-->
					<div class="row div-margintop">
						<div class="col-md-6">
							<div class="form-group">
								<div class="col-md-offset-4 col-sm-8">
									<button type="button" id="help-send" class="btn btn-primary" onclick="helpFormsubmit()">Send
									</button>
									<!--<button type="button" id="help-notify" class="btn btn-primary" onclick="helpNotify()">Notify
									</button>-->
								</div>
							</div>

						</div>

					</div> <!--row-->
				</form>
				
				

				
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
		$('#main_menu_help_desk').addClass('active');
		function helpNotify(){
			$.ajax({
					type: 'get',
					url: base_url + '/help/notify',
					cache: false,
					data:{'_token':$('#_token').val()},
					success: function (json) {
						console.log(json);	
					},
					error : function(){
						alert('Something went wrong, Please try again later');
						
					}
				});

		}

		function helpFormsubmit(){
			if ($("#help-form").valid()) {
				$('#help-send').text('Sending...')
				$('#help-send').attr('disabled', 'disabled');
				
				$.ajax({
					type: 'post',
					url: base_url + '/help/send',
					cache: false,
					data: $('#help-form').serialize(),
					success: function (json) {
						//$('#mau').text(json.totalunits);
						//$('#mab').text(json.calculatebill.toFixed(2));
						//var result = jQuery.parseJSON(json);
						if (json) {

							$('#subject').val('');
							$('#message').val('');
							$.gritter.add({
                                title: 'Success',
                                text: 'Your request sent Successfully.',
                                class_name: 'with-icon check-circle success'
                            });
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
						}else{
							alert('Something went wrong, Please try again later');
						}

						$('#help-send').attr('disabled', false);
						$('#help-send').text('Send');
					},
					error : function(){
						alert('Something went wrong, Please try again later');
						$('#help-send').attr('disabled', false);
						$('#help-send').text('Send')
					}
				});
			}
		}

		
		
		
		$('.datepicker').datepicker({
			orientation:"bottom left"
		});

		function close_btn(){
			window.location.href = base_url + '/main';
		}
	</script>
	@endsection
