	
	@extends('admin.layout')
	
	@section('css')
		<style>
		.nav-tabs-custom {
			margin-bottom: 0px;
			background: none;
		}
		.nav-tabs-custom>ul.nav-tabs{
			float:right;
		}
		.mtop10{
			margin-top:10px;
		}
		.mtop5{
			margin-top:5px;
		}
		.txtright{
			text-align: right;
			right: 5px;
		}
		.content{
			min-height:0;
		}
		.small-box .icon {
			top: -22px;
		}
		.weight7{
			font-weight: 700;
		}
		.chart-cnt{
			background-color: #ddd;
			padding:10px;
		}
		.marginh10 {
			margin: 10px 0;
		}
		.text-right{
			text-align: right;
		}
		.chart {
			padding: 10px;
			margin: 10px 0;
		}
		.content-wrapper{
			min-height: auto !important;
		}
		.chart p {
			margin: 0;
		}
		.chart p label {
			color: #000000;
			font-weight: 900;
			font-size:12px;
		}
		.clcheckbox {
			vertical-align:middle !important;
			margin-right: 10px !important;
			margin-top:0 !important;
		}
		.mt10{
			margin-top:10px;
		}
		</style>
	@endsection
	
	
	@section('content')
			<div class="col-md-12 box-header with-border">
				<h4 class="col-md-5">
					{{$name}}
					<div class="clear"></div>
				</h4>	
				<h4 class="col-md-6">
					<span id="datetimecnt" >{{date('d-m-Y H:i')}}</span>
					<div class="clear"></div>
				</h4>				
			</div>
			
			<div class="col-md-6 chart">
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
				<div  class="col-md-12 no-padding mt10">
					<div  class="col-md-6"><input type="checkbox" name="cl1" id="cl1" class="clcheckbox" value="1" @if($grouping && $grouping->station1_cl==1) {{ 'checked' }} @endif /><label for="cl1">Critical Level</label></div>
					<div  class="col-md-6">
						<select class="form-control select2 station" name="station1" style="width: 100%;" onchange="chagneStation('station1',this.value)" >
							<option value="">Select Station</option>
							@foreach($stations as $val)
								<option value="{{$val->id}}" @if($s1->station_id==$val->id){{'selected'}}@endif >{{$val->station_id.' - '.$val->station_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 chart">
				<div id="chartCnt2">
								
				</div>
				<div  class="col-md-6">
					<p><label>Cope Level: {{$s2->copelevel}}</label></p>
					<p><label>Invert Level: {{$s2->invertlevel}}</label></p>
					<p><label>Operation Level: {{$s2->operationlevel}}</label></p>
				</div>
				<div  class="col-md-6">
					<p><label>Max: <span id="s2max">{{$s2->max}}</span></label></p>
					<p><label>Min: <span id="s2min">{{$s2->min}}</span></label></p>
					<p><label>Current Water Level: <span id="s2wl">{{$s2->waterlever_mrl}}</span></label></p>
				</div>
				<div  class="col-md-12 no-padding mt10">
					<div  class="col-md-6"><input type="checkbox" name="cl2" id="cl2" class="clcheckbox" value="1" @if($grouping && $grouping->station2_cl==1) {{ 'checked' }} @endif/><label for="cl2">Critical Level</label></div>
					<div  class="col-md-6">
						<select class="form-control select2 station" name="station2" style="width: 100%;"  onchange="chagneStation('station2',this.value)" >
							<option value="">Select Station</option>
							@foreach($stations as $val)
								<option value="{{$val->id}}" @if($s2->station_id==$val->id){{'selected'}}@endif >{{$val->station_id.' - '.$val->station_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 chart">
				<div id="chartCnt3">
								
				</div>
				<div  class="col-md-6">
					<p><label>Cope Level: {{$s3->copelevel}}</label></p>
					<p><label>Invert Level: {{$s3->invertlevel}}</label></p>
					<p><label>Operation Level: {{$s3->operationlevel}}</label></p>
				</div>
				<div  class="col-md-6">
					<p><label>Max: <span id="s3max">{{$s3->max}}</span></label></p>
					<p><label>Min: <span id="s3min">{{$s3->min}}</span></label></p>
					<p><label>Current Water Level: <span id="s3wl">{{$s3->waterlever_mrl}}</span></label></p>
				</div>
				<div  class="col-md-12 no-padding mt10">
					<div  class="col-md-6"><input type="checkbox" name="cl3" id="cl3" class="clcheckbox" value="1" @if($grouping && $grouping->station3_cl==1) {{ 'checked' }} @endif/><label for="cl3">Critical Level</label></div>
					<div  class="col-md-6">
						<select class="form-control select2 station" name="station3" style="width: 100%;"  onchange="chagneStation('station3',this.value)" >
							<option value="">Select Station</option> 
							@foreach($stations as $val)
								<option value="{{$val->id}}" @if($s3->station_id==$val->id){{'selected'}}@endif >{{$val->station_id.' - '.$val->station_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6 chart">
				<div id="chartCnt4">
								
				</div>
				<div  class="col-md-6">
					<p><label>Cope Level: {{$s4->copelevel}}</label></p>
					<p><label>Invert Level: {{$s4->invertlevel}}</label></p>
					<p><label>Operation Level: {{$s4->operationlevel}}</label></p>
				</div>
				<div  class="col-md-6">
					<p><label>Max: <span id="s4max">{{$s4->max}}</span></label></p>
					<p><label>Min: <span id="s4min">{{$s4->min}}</span></label></p>
					<p><label>Current Water Level: <span id="s4wl">{{$s4->waterlever_mrl}}</span></label></p>
				</div>
				<div  class="col-md-12 no-padding mt10">
					<div  class="col-md-6"><input type="checkbox" name="cl4" id="cl4" class="clcheckbox" value="1" @if($grouping && $grouping->station4_cl==1) {{ 'checked' }} @endif /><label for="cl4">Critical Level</label></div>
					<div  class="col-md-6">
						<select class="form-control select2 station" name="station4" style="width: 100%;"  onchange="chagneStation('station4',this.value)" >
							<option value="">Select Station</option>
							@foreach($stations as $val)
								<option value="{{$val->id}}" @if($s4->station_id==$val->id){{'selected'}}@endif >{{$val->station_id.' - '.$val->station_name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
	
		
			
	@endsection
	
	
	@section('js')
	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script>
		var chart1='';
		var chart2='';
		var chart3='';
		var chart4='';
		var url = "{{URL::to('get-dashboard-rawdata')}}";		
						
		$(function(){	
					
			Highcharts.setOptions({
				global: {
					useUTC: false
				}, 
				lang:{
					rangeSelectorZoom: ''
				}
			});
			
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
							zoomType: 'x'
						},

						title: {
							text: "{{$s1->stationID.' - '.$s1->name}}"
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
							
							inputEnabled: false,

							buttons: [{
								type: 'all',
								text: 'Reset'
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
			
			setTimeout(function(){
				var cl1 = $('#cl1:checked').val() || 0; 
				if(cl1<=0){ 
					var series = chart1.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart1.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart1.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s1->criticallevel}}";
					chart1.yAxis[0].update({
						visible: true
					});				
				}
			},2000);
	}
	var call2 = function(){		
			$.ajax({
				type: 'post',
				url: url,
				data: {
					"_token": "{{ csrf_token() }}",
					"station_id": "{{$s2->station_id}}",
				},
				success: function (result) {			
					$('#datetimecnt').text(result.time);
					$('#s2max').text(result.max);
					$('#s2min').text(result.min);
					$('#s2wl').text(result.waterlever_mrl);
					var data = result.data;
					
					
					chart2 = Highcharts.stockChart('chartCnt2', {

						chart: {
							zoomType: 'x'
						},
						title: {
							text: "{{$s2->stationID.' - '.$s2->name}}"
						},

						subtitle: {
							text: ''
						},

						xAxis: {
							gapGridLineWidth: 0
						},
						
						tooltip: {
							formatter: function() {
								
								return  '<b>Water Level:' + (this.y).toFixed(2) +' mRL</b><br/>Datetime:' +
									Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							}
						},
						yAxis: {
						  plotLines: [{
								color: 'blue', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s2->percentage50}}", // Value of where the line will appear
								width: 2, // Width of the line    
								label: {
									text: '50%'
								}
							  },{
								color: 'green', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s2->percentage75}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '75%'
								}
							  }	,{
								color: 'yellow', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s2->percentage90}}", // Value of where the line will appear
								width:  2,  
								label: {
									text: '90%'
								}     
							  }	,{
								color: 'red', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s2->totalPercentage}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '100%'
								}
							  }	,{
								color: '#ef77c3', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s2->criticallevel}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: 'Critical Level'
								}
							  }
							  							  
						  ],
						  
						  max:{{$s2->ymax}},
						  opposite:false
						},

						
						rangeSelector: {
							
							inputEnabled: false,
							buttons: [{
								type: 'all',
								text: 'Reset'
							}]
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
			setTimeout(function(){
				var cl2 = $('#cl2:checked').val() || 0;
				if(cl2<=0){
					var series = chart2.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart2.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart2.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s2->criticallevel}}";
					chart2.yAxis[0].update({
						visible: true
					});				
				}
			},2000);
	}
	var call3 = function(){
			$.ajax({
				type: 'post',
				url: url,
				data: {
					"_token": "{{ csrf_token() }}",
					"station_id": "{{$s3->station_id}}",
				},
				success: function (result) {			
					$('#datetimecnt').text(result.time);
					$('#s3max').text(result.max);
					$('#s3min').text(result.min);
					$('#s3wl').text(result.waterlever_mrl);
					var data = result.data;
					
					
					chart3 = Highcharts.stockChart('chartCnt3', {
						chart: {
							zoomType: 'x'
						},

						title: {
							text: "{{$s3->stationID.' - '.$s3->name}}"
						},

						subtitle: {
							text: ''
						},

						xAxis: {
							gapGridLineWidth: 0
						},
						
						tooltip: {
							formatter: function() {
								
								return  '<b>Water Level:' + (this.y).toFixed(2) +' mRL</b><br/>Datetime:' +
									Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							}
						},
						yAxis: {
						  plotLines: [{
								color: 'blue', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s3->percentage50}}", // Value of where the line will appear
								width: 2, // Width of the line    
								label: {
									text: '50%'
								}
							  },{
								color: 'green', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s3->percentage75}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '75%'
								}
							  }	,{
								color: 'yellow', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s3->percentage90}}", // Value of where the line will appear
								width:  2,  
								label: {
									text: '90%'
								}     
							  }	,{
								color: 'red', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s3->totalPercentage}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '100%'
								}
							  }	,{
								color: '#ef77c3', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s3->criticallevel}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: 'Critical Level'
								}
							  }					  
						  ],
						  
						  max:{{$s3->ymax}},
						  opposite:false
						},

						
						rangeSelector: {
							
							inputEnabled: false,
							buttons: [{
								type: 'all',
								text: 'Reset'
							}]
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
			
			setTimeout(function(){
				var cl3 = $('#cl3:checked').val() || 0;
				if(cl3<=0){
					var series = chart3.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart3.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart3.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s3->criticallevel}}";
					chart3.yAxis[0].update({
						visible: true
					});				
				}
			},2000);	
	}
	var call4 = function(){
			$.ajax({
				type: 'post',
				url: url,
				data: {
					"_token": "{{ csrf_token() }}",
					"station_id": "{{$s4->station_id}}",
				},
				success: function (result) {			
					$('#datetimecnt').text(result.time);
					$('#s4max').text(result.max);
					$('#s4min').text(result.min);
					$('#s4wl').text(result.waterlever_mrl);
					var data = result.data;
					
					
					chart4 = Highcharts.stockChart('chartCnt4', {
						chart: {
							zoomType: 'x'
						},

						title: {
							text: "{{$s4->stationID.' - '.$s4->name}}"
						},

						subtitle: {
							text: ''
						},

						xAxis: {
							gapGridLineWidth: 0
						},
						
						tooltip: {
							formatter: function() {
								
								return  '<b>Water Level:' + (this.y).toFixed(2) +' mRL</b><br/>Datetime:' +
									Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							}
						},
						yAxis: {
						  plotLines: [{
								color: 'blue', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s4->percentage50}}", // Value of where the line will appear
								width: 2, // Width of the line    
								label: {
									text: '50%'
								}
							  },{
								color: 'green', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s4->percentage75}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '75%'
								}
							  }	,{
								color: 'yellow', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s4->percentage90}}", // Value of where the line will appear
								width:  2,  
								label: {
									text: '90%'
								}     
							  }	,{
								color: 'red', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s4->totalPercentage}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '100%'
								}
							  }	,{
								color: '#ef77c3', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$s4->criticallevel}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: 'Critical Level'
								}
							  }					  
						  ],
						  
						  max:{{$s4->ymax}},
						  opposite:false
						},

						
						rangeSelector: {
							
							inputEnabled: false,
							buttons: [{
								type: 'all',
								text: 'Reset'
							}]
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
						credits: { enabled: false },
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
			
			setTimeout(function(){
				var cl4 = $('#cl4:checked').val() || 0;
				if(cl4<=0){
					var series = chart4.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart4.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart4.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s4->criticallevel}}";
					chart4.yAxis[0].update({
						visible: true
					});				
				}
			},2000);	
	}
	var interval = 60000;
	setInterval(function() { call1();call2();call3();call4(); }, interval);
			call1();call2();call3();call4();
			
			$('#cl1').click(function(){
				var cl1 = $('#cl1:checked').val() || 0; 
				if(cl1<=0){ 
					var series = chart1.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart1.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart1.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s1->criticallevel}}";
					chart1.yAxis[0].update({
						visible: true
					});				
				}
				$.get("{{URL::to('change-cl-station-group/'.$grouping->id.'/station1_cl/')}}/"+cl1,function(result){
									
				});
			});
			
			$('#cl2').click(function(){
				var cl2 = $('#cl2:checked').val() || 0;
				if(cl2<=0){
					var series = chart2.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart2.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart2.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s2->criticallevel}}";
					chart2.yAxis[0].update({
						visible: true
					});				
				}
				$.get("{{URL::to('change-cl-station-group/'.$grouping->id.'/station2_cl/')}}/"+cl2,function(result){
									
				});
			});
			$('#cl3').click(function(){
				var cl3 = $('#cl3:checked').val() || 0;
				if(cl3<=0){
					var series = chart3.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart3.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart3.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s3->criticallevel}}";
					chart3.yAxis[0].update({
						visible: true
					});				
				}
				$.get("{{URL::to('change-cl-station-group/'.$grouping->id.'/station3_cl/')}}/"+cl3,function(result){
									
				});
			});
			$('#cl4').click(function(){
				var cl4 = $('#cl4:checked').val() || 0;
				if(cl4<=0){
					var series = chart4.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value=0;
					chart4.yAxis[0].update({
						visible: true
					});
				}else{
					var series = chart4.yAxis[0].series[0].yAxis.plotLinesAndBands[4];
					series.options.value="{{$s4->criticallevel}}";
					chart4.yAxis[0].update({
						visible: true
					});				
				}
				$.get("{{URL::to('change-cl-station-group/'.$grouping->id.'/station4_cl/')}}/"+cl4,function(result){
									
				});
			});
			
		});
		
		function chagneStation(field,value){
			$.get("{{URL::to('change-station-group/'.$grouping->id)}}/"+field+'/'+value,function(result){
				location.reload();					
			});
		}
		
		
		
	</script>
	@endsection