<br/>
<div class="col-md-6">
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>Appliance</th>
				<th>Watts/hour</th>
				<th>Unit Usage</th>
			</tr>
			
		</thead>
		<tbody>
			<?php
			$sum = 0;
			?>
			@foreach ($usage_list as $key => $value)
			<tr>
				<td>{{$value->startdate}}</td>
				<td>{{$value->name}}</td>
				<td>{{$value->wattshour}}</td>
				<td>{{$value->consump}}</td>
				<?php 
				$sum += $value->consump ;
				?>
			</tr>
			@endforeach
			<tfoot>
				<tr>
					<th></th>
					<th></th>
					<th align="right">Total</th>
					<th>{{$sum}}</th>
				</tr>
			</tfoot>
			
		</tbody>
	</table>
</div>
