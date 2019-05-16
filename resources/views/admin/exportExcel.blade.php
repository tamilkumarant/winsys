	@extends('admin.layoutwlsummary')
	
	@section('css')
	<style>
	</style>
	@endsection
	@section('content')
	<div class="col-md-12 chart">
		<div id="chartCnt1">
						
		</div>
		<div  class="col-md-6">
			<p><label>Cope Level: {{$s1->copelevel}}</label></p>
			<p><label>Invert Level: {{$s1->invertlevel}}</label></p>
			<p><label>Operation Level: {{$s1->operationlevel}}</label></p>
		</div>
		<div  class="col-md-6">
			<p><label>Max: <span id="s1max">{{$s1->max}}</span></label></p>
			<p><label>Min: <span id="s1min">{{$s1->min}}</span></label></p>
			<p><label>Current Water Level: <span id="s1wl">{{$s1->waterlever_mrl}}</span></label></p>
		</div>
		
	</div>
	
	@endsection
	@section('js')
	
    <script src="{{asset('/public/admin/plugins/jQuery/jQuery-2.1.3.min.js')}}"></script>	
    <script src="{{asset('/public/admin/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="{{asset('/public/admin/dist/js/html2canvas.js')}}" type="text/javascript"></script>
    <script src="{{asset('/public/admin/dist/js/jquery.canvasjs.min.js')}}" type="text/javascript"></script>

	<script>
		var chart1='';
		var url = "{{URL::to('get-dashboard-rawdata-service')}}";		
		var saveimgurl = "{{URL::to('save-image')}}";		
		
		
		EXPORT_WIDTH = 1000;

		function save_chart(chart) {
			var render_width = EXPORT_WIDTH;
			var render_height = render_width * chart.chartHeight / chart.chartWidth

			// Get the cart's SVG code
			var svg = chart.getSVG({
				exporting: {
					sourceWidth: chart.chartWidth,
					sourceHeight: chart.chartHeight
				}
			});

			// Create a canvas
			var canvas = document.createElement('canvas');
			canvas.height = render_height;
			canvas.width = render_width;
			canvas.id = 'mytestid';
			document.body.appendChild(canvas);

			// Create an image and draw the SVG onto the canvas
			var image = new Image;
			image.onload = function() {
				canvas.getContext('2d').drawImage(this, 0, 0, render_width, render_height);
			};
			  image.src = 'data:image/svg+xml;base64,' + window.btoa(svg);
		}
		
						
	$(function(){	
				
		Highcharts.setOptions({
			global: {
				useUTC: false
			}, 
			lang:{
				rangeSelectorZoom: ''
			}
		});
			
		var saveimg = function(){
			save_chart($('#chartCnt1').highcharts());
				html2canvas($("#mytestid"), {
					onrendered: function(canvas) {
						console.log(canvas);
						canvas.id = 'image';
						document.body.appendChild(canvas);				
						var mycanvas = document.getElementById("image"); 
						var image    = mycanvas.toDataURL("image/png"); 
						var station_id="{{$s1->station_id}}";
						$.post(saveimgurl,{data:image,_token: "{{ csrf_token() }}",station_id:station_id},function(result){
							var data = JSON.parse(result);
							var next_station_id = data.next_station_id;
							if(next_station_id>0){
								window.location.href = "{{URL::to('export-pdf')}}/"+next_station_id;
							}
						});
					}
				});
		}
		var interval = 100000;
		// var interval = 8000;
		setTimeout(function(){saveimg(); }, interval);
			
		var call1 = function(){				
			$.ajax({
				type: 'post',
				url: url,
				data: {
					"_token": "{{ csrf_token() }}",
					"station_id": "{{$s1->station_id}}",
				},
				success: function (result) {			
					$('#datetimecnt').text(result.time);
					$('#s1max').text(result.max);
					$('#s1min').text(result.min);
					$('#s1wl').text(result.waterlever_mrl);
					var data = result.data;
					chart1 = Highcharts.stockChart('chartCnt1', {
						chart: {
							zoomType: 'x',
							// resetZoomButton:{
							// 	theme: {
							// 		display: 'none'
							// 	}
							// }
						},

						title: {
							text: ""
							// text: "{{$s1->stationID.' - '.$s1->name}}"
						},


						subtitle: {
							text: ''
						},

						xAxis: {
							gapGridLineWidth: 0
						},
						
						yAxis: {
						  plotLines: [{
								color: 'blue', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s1->percentage50}}", // Value of where the line will appear
								width: 2, // Width of the line    
								label: {
									text: '50%'
								}
							  },{
								color: 'green', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s1->percentage75}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '75%'
								}
							  }	,{
								color: 'yellow', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s1->percentage90}}", // Value of where the line will appear
								width:  2,  
								label: {
									text: '90%'
								}     
							  }	,{
								color: 'red', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s1->totalPercentage}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '100%'
								}
							  }	,{
								color: '#ef77c3', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s1->criticallevel}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: 'Critical Level'
								}
							  }	
							  
						  ],						  
						  max:{{$s1->ymax}},
						  opposite:false
						},
						rangeSelector: {
							enabled: false,							
							inputEnabled: false,
							buttons: [{
								type: 'all',
								text: '',
								// text: 'Reset'
							}]
						},						
						tooltip: {
							formatter: function() {
								
								return  '<b>Water Level:' + (this.y).toFixed(2) +' mRL</b><br/>Datetime:' +
									Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							}
						},
						navigator: 
						{
							enabled: false
						},
						credits: 
						{
						  enabled: false
						},
						scrollbar: {
							enabled: false
						},
						exporting: {
						 enabled: false
						},
						series: [{
							name: 'Water Level',
							data: data,
							tooltip: {
								valueDecimals: 2
							}
						}]
					});					
				}
			});
		}		
		call1();
	});
	
	</script>
	@endsection