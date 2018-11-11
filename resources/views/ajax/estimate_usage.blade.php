
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="myModalLabel">Instruction Report</h4>
</div>
<div class="modal-body">
	<form class="form-horizontal" autocomplete="off" id="formReport">
		<input type="hidden" id="_token" name="_token" value="{{ csrf_token()}}">
		<div class="row" >
			<div class="col-md-12">
				<table class="table">
					<thead>
						<tr>
							@if($BudgetEstimation->budget < $estimate_amount)
								<th></th>
							@endif
							<th>Appliance</th>
							<th>Usage Hours/Day</th>
							<th>Units Needed</th>
						</tr>

					</thead>
					<tbody>

						@foreach ($est_list as $key => $value)
						<tr>
							@if($BudgetEstimation->budget < $estimate_amount)
								<td>
									<input type="checkbox" name="is_reduce[]" value="{{$value['device_id']}}">
								</td>
							@endif
							<td>{{$value['name']}}
								<input type="hidden" name="device_name[]" value="{{$value['name']}}">
								<input type="hidden" name="device_id[]" value="{{$value['device_id']}}">
								<input type="hidden" name="usg_hour[]" value="{{$value['usg_hour']}}">
								<input type="hidden" name="avg_usage[]" value="{{$value['avg_usage']}}">
							</td>
							<td>{{$value['usg_hour']}}</td>
							<td>{{$value['avg_usage']}}</td>

						</tr>
						@endforeach
						<tfoot>
							<tr>
								@if($BudgetEstimation->budget < $estimate_amount)
								<th></th>
								@endif
								<th></th>
								<th align="right">Total</th>
								<th>{{$total_units}}
									<input type="hidden" name="total_units" value="{{$total_units}}">
									<input type="hidden" name="estimate_amount" value="{{$estimate_amount}}">
									<input type="hidden" name="last_billing_date" value="{{$BudgetEstimation->last_billing_date}}">
									<input type="hidden" name="next_billing_date" value="{{$BudgetEstimation->next_billing_date}}">
									<input type="hidden" name="budget" value="{{$BudgetEstimation->budget}}">
									<input type="hidden" name="budget_units" value="{{$BudgetEstimation->budget_units}}">
									<input type="hidden" name="home_id" value="{{$BudgetEstimation->home_id}}">
									<input type="hidden" name="estimate_amount" value="{{$estimate_amount}}">
								</th>
							</tr>
							<tr>
								@if($BudgetEstimation->budget < $estimate_amount)
								<th></th>
								@endif
								<th></th>
								<th>Amount</th>
								<th>{{sprintf('%0.2f',$estimate_amount)}}</th>
							</tr>
							<tr>
								@if($BudgetEstimation->budget < $estimate_amount)
								<th></th>
								@endif
								<th></th>
								<th>Budget</th>
								<th>{{sprintf('%0.2f',$BudgetEstimation->budget)}}</th>
							</tr>
						</tfoot>

					</tbody>
				</table>
			</div>
		</div>
	</form>
</div>
<div class="modal-footer">
	@if($BudgetEstimation->budget < $estimate_amount)
	<span class="text-danger">Estimation is not under budget. Please choose the device/s for reducing the usage and regenerate the report.</span>
			<button type="button" class="btn btn-primary" onclick="regenerateEstimateUsage()">Regenerate Report</button>
	@else
		<button type="button" class="btn btn-primary" onclick="saveEstimateUsage()">Save</button>
	@endif
	
	
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

</div>




