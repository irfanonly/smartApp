
$(document).ready(function(){

	'use strict';

	var m1 = new Morris.Line({
		// ID of the element in which to draw the chart.
		element: 'line-chart',
		// Chart data records -- each entry in this array corresponds to a point on
		// the chart.
		data: yearRev,
		xkey: 'y',
		ykeys: ['a'],
		labels: ['Revenue'],
		lineColors: ['#D9534F', '#5BC0DE'],
		//pointFillColors: ['#fff', '#000'],
		lineWidth: '3px',
		hideHover: true,
		gridTextColor: '#fff',
		grid: false
	});


	// Tooltip for flot chart
	function showTooltip(x, y, contents) {
		$('<div id="tooltip" class="tooltipflot">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 5
		}).appendTo('body').fadeIn(200);
	}



	// var newCust = [
	// 	[months[0], 50], [months[1], 65], [months[2],55], [months[3], 62], [months[4], 55],
	// 	[months[5], 58], [months[6], -65], [months[7], 58], [months[8], 63], [months[9], 65],
	// 	[months[10], 83], [months[11], 78]
	// ];
    //
	// var retCust = [[months[0], 20], [months[1], -35], [months[2],20], [months[3], 25], [months[4], 17], [months[5], 10], [months[6],15], [months[7],28],
	// 	[months[8],15], [months[9],20], [months[10],35], [months[11],30]];



	var plot = $.plot($('#basicflot'),[{
		data: pastRev,
		label: 'Revenue',
		color: '#cfd3da'
	},
	{
		data: currRev,
		label: 'Revenue',
		color: '#06b5cf',
	}],
	{
		series: {
			lines: {
				show: false,
			},

			splines: {
				show: true,
				tension: 0.3,
				lineWidth: 2,
				fill: .50
			},

			shadowSize: 0
		},

		points: { show: true },

		legend: {
			container: '#basicFlotLegend',
			noColumns: 0
		},

        grid: {
            hoverable: true,
            clickable: true,
            backgroundColor: 'transparent',
            color: 'transparent',
            show: true,
            markings: [
                { yaxis: { from: 0, to: 0 }, color: "#000000"}
            ],
            markingsLineWidth: 1
        },

		yaxis: {
			min: min_val,
			max: max_val,
			color: '#f3f5f7',
			tickLength:0
		},

		xaxis: {
			color: '#f3f5f7',
            ticks: [
            	[0,'Jan'],
				[1,'Feb'],
				[2,'Mar'],
				[3,'Apr'],
				[4,'May'],
				[5,'Jun'],
				[6,'Jul'],
				[7,'Aug'],
				[8,'Sep'],
				[9,'Oct'],
				[10,'Nov'],
				[11,'Dec'],
			],
		}

	});

	var previousPoint = null;

	$('#basicflot').bind('plothover', function (event, pos, item) {
		$('#x').text(pos.x.toFixed(2));
		$('#y').text(pos.y.toFixed(2));

		if(item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$('#tooltip').remove();
				var x = item.datapoint[0].toFixed(2),
				y = item.datapoint[1].toFixed(2);

				showTooltip(item.pageX, item.pageY, item.series.label + ' of ' + x + ' = ' + y);
			}

		} else {
			$('#tooltip').remove();
			previousPoint = null;
		}
	});

	$('#basicflot').bind('plotclick', function (event, pos, item) {
		if (item) {
			plot.highlight(item.series, item.datapoint);
		}
	});

	// Knob
	$('.dial-success').knob({
		readOnly: true,
		width: '70px',
		bgColor: '#E7E9EE',
		fgColor: '#259CAB',
		inputColor: '#262B36'
	});

	$('.dial-danger').knob({
		readOnly: true,
		width: '70px',
		bgColor: '#E7E9EE',
		fgColor: '#D9534F',
		inputColor: '#262B36'
	});

	$('.dial-info').knob({
		readOnly: true,
		width: '70px',
		bgColor: '#66BAC4',
		fgColor: '#fff',
		inputColor: '#fff'
	});

	$('.dial-warning').knob({
		readOnly: true,
		width: '70px',
		bgColor: '#E48684',
		fgColor: '#fff',
		inputColor: '#fff'
	});


});
