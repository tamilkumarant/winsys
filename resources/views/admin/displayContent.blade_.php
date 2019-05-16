	<?php 
	
		use App\Helper;
		$waterlever_mrl = isset($lastRawdata->waterlever_mrl)?($lastRawdata->waterlever_mrl):"N/A";
		$datetime = isset($lastRawdata->datetime)?($lastRawdata->datetime):date('Y-m-d H:i');
		$battery_voltage = isset($lastRawdata->battery_voltage)?($lastRawdata->battery_voltage):"N/A";
	?>
	@extends('admin.layoutwlsummary')
	
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
			background-color: #fff;
			padding:10px;
		}
		.marginh10 {
			margin: 10px 0;
		}
		.text-right{
			text-align: right;
		}
		#tableCnt{
			overflow-x:scroll;
		}
		</style>
	@endsection
	
	
	@section('content')
		
        <section class="content">
			<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <p>{{$waterlever_mrl}} mRL<sup style="font-size: 20px"></sup></p>
                  <p>Water Level</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <p>{{date('d-m-Y H:i',strtotime($datetime))}}</p>
                  <p>Date & Time</p>
                </div>
                <div class="icon">
                  <i class="ion ion-clock"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <p>{{number_format($rateof_change,3)}} mRL</p>
                  <p>Rate of Change</p>
                </div>
                <div class="icon">
                  <i class="ion ion-arrow-graph-up-right"></i>
                </div>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <p>{{$battery_voltage}} V</p>
                  <p>Battery Voltage</p>
                </div>
                <div class="icon">
                  <i class="ion ion-battery-half"></i>
                </div>
              </div>
            </div><!-- ./col -->
			</div>
		</section>
		<div class="col-lg-12 chart-cnt">
			<form action="" method="post" >
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="col-lg-12 txtright">
					<div class="col-lg-2 no-padding txtright">
						<span>Cope Level(mRl)</span><label>{{$station->copelevel}}</label>
					</div>
					<div class="col-lg-2 no-padding txtright">
						<span>Operation Level(mRl)</span><label>{{$station->operationlevel}}</label>
					</div>
					<div class="col-lg-2 no-padding txtright">
						<span>Invert Level(mRl)</span><label>{{$station->invertlevel}}</label>
					</div>
					<div class="col-lg-2 no-padding txtright">
						<span>Critical Level(mRl)</span><label>{{$station->criticallevel}}</label>
					</div>
				</div>
				<div id="info" style="col-md-12" style="padding:5px 0;">	
					<div class="col-md-1 no-padding mtop10 txtright">
						<span>Station Name</span>
					</div>	
					<div class="col-md-4 col-sm-12 no-padding mtop5">
						<select name="station_id" class="form-control station_id" required onchange="selectStation(this.value);" >
							<option value="">Select Station</option>
							@foreach($stations as $key=>$val)
							<option value="{{$val->id}}"  @if($val && $val->id==$station->id){{'selected'}} @endif >{{$val->station_id.' '.$val->station_name}}</option>
							@endforeach
						</select>
					</div>			
					<div class="col-md-6 col-sm-12  no-padding">						
						<div class="nav-tabs-custom col-md-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#chartCnt" data-toggle="tab">Chart</a></li>
								<li><a href="#tableCnt" data-toggle="tab">Table</a></li>
								<li><a href="#stationLiveCnt" data-toggle="tab">Station Image</a></li>
							</ul>
						</div>
					</div>
					<div style="clear:both;"></div>
				</div> <?php /* */ ?>
				<div class="col-md-12 marginh10">
					<div class="col-md-2 col-md-offset-2 text-right">
						<label>Date and time range:</label>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" class="form-control pull-right daterange" id="daterange" name="daterange" value="{{$daterange}}" readonly>
							</div>
						</div>
					</div>
					<div class="col-md-2 ">
						<input type="submit" name="submit" class="btn btn-success" value="Search"  />
					</div>
					<div class="col-md-2 ">
						<input type="submit" name="downloadCSV" class="btn btn-info" value="Download"  />
					</div>
				</div>
				<div class="col-md-12  no-padding nav-tabs-custom">
					<div class="nav-tabs-custom">	
						<div class="tab-content">
							<div class="active tab-pane" id="chartCnt">
								
							</div>
							<div class="tab-pane" id="tableCnt">
								<div class="box-body">
									<table class="customTable table table-bordered table-striped">
										<thead>
										  <tr>
											<th>Date & Time</th>
											<th>Water Depth(m)</th>
											<th>Water Level(mRL)</th>
											<th>Rate of Change(m/min)</th>
											<th>Status</th>
										  </tr>
										</thead>
										<tbody>
											
											@foreach($allRawdata as $key=>$val)
												<?php 	$statusText = ($val->maintenance_status==1)?('Maintenance'):('Normal'); 
														$secondlastKey = ($key+1);
														if($secondlastKey<0){$secondlastKey=0;}

														$secondmrl = '';$seconddatetime='';
														if( isset($allRawdata[$secondlastKey]) && isset($allRawdata[$secondlastKey]->waterlever_mrl) ){
															$secondmrl = ($allRawdata[$secondlastKey]->waterlever_mrl);
														}
														if( isset($allRawdata[$secondlastKey]) && isset($allRawdata[$secondlastKey]->datetime) ){
															$seconddatetime = ($allRawdata[$secondlastKey]->datetime);
														}

														// $secondmrl = '';// isset($allRawdata[$secondlastKey]->waterlever_mrl)?($allRawdata[$secondlastKey]->waterlever_mrl):0;
														// $seconddatetime = '';// isset($allRawdata[$secondlastKey]->datetime)?($allRawdata[$secondlastKey]->datetime):'';
														$firstmrl = $val->waterlever_mrl;
														$firstdatetime = $val->datetime;
														$rateof_change = $firstmrl-$secondmrl;
														$min = Helper::getMinutesFromDates($seconddatetime,$firstdatetime);
														if($min>0){
															$rateof_change = $rateof_change / $min;
														}
												?>
												<tr>
													<td>{{date('Y-m-d H:i',strtotime($val->datetime))}}</td>
													<td>{{$val->waterlevel_meter}}</td>
													<td>{{$val->waterlever_mrl}}</td>
													<td>{{number_format($rateof_change,3)}}</td>
													<td>{{$statusText}}</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane" id="stationLiveCnt">	
								@if($station->image)
									<img src="{{URL::to('public/stations/'.$station->image)}}" width="100%" height="100%" />
								@endif
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	
	
		
			
	@endsection
	
	
	@section('js')
	<script>
	
		$(document).ready(function () {
		
			$('.customTable').DataTable({
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"sorting":[],
				"info": true,
				"autoWidth": false,
				"aaSorting": []
			});
			$('#daterange').daterangepicker({
				timePicker: true, 
				timePickerIncrement: 1, 
				format: 'YYYY/MM/DD HH:mm',
			});
						
		});
		
		$(function(){
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});
				
			var formData = $('form').serialize();
			
			// var url = "{{URL::to('get-chart-rawdata')}}";
			var url = "{{URL::to('../con/detailsJsonnew.php?sid='.$station->pub_id)}}";
			// var url = "{{URL::to('../con/detailsJsonnew.php?sid=CWS148')}}&type=wa";
			
			$.ajax({
				type: 'post',
				url: url,
				data: {
					"_token": "{{ csrf_token() }}",
					"daterange": $('.daterange').val(),
					"station_id": $('.station_id').val(),
					"percentage50": {{$percentage50}},
					"totalPercentage": {{$totalPercentage}},
				},
				success: function (result) {
					var data = result;
					// var data2 = result.data2;
					
					// console.log(data2);
					
					/* var PLOTBANDS = [{
						color: 'green',
						from: 1496287201000,
						to: 1496462822000,
						id: ''
					} */
					// ,{
						// color: 'pink',
						// from: 9,
						// to: 10,
						// id: 'plotband-9-10'
					// },{
						// color: 'red',
						// from: 11,
						// to: 12,
						// id: 'plotband-11-12'
					// }
					// ];
					
					Highcharts.stockChart('chartCnt', {
						// chart: {
							// zoomType: 'x',	
							// type: 'arearange',
						// },
						// showInLegend:true,
						// legend: {
							// layout: 'vertical',
							// align: 'right',
							// verticalAlign: 'middle'
						// },
								
						/* title: {
						},

						subtitle: {
							text: ''
						},
						
						yAxis: [
							{
							plotLines: [{
								color: 'blue', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$percentage50}}", // Value of where the line will appear
								width: 2, // Width of the line    
								label: {
									text: '50%'
								}
							  },{
								color: 'green', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$percentage75}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '75%'
								}
							  }	,{
								color: 'yellow', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$percentage90}}", // Value of where the line will appear
								width:  2,  
								label: {
									text: '90%'
								}     
							  }	,{
								color: 'red', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$totalPercentage}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: '100%'
								}
							  }	,{
								color: '#ef77c3', // Color value
								dashStyle: 'solid', // Style of the plot line. Default to solid
								value: "{{$station->criticallevel}}", // Value of where the line will appear
								width: 2,  
								label: {
									text: 'Critical Level'
								}
							  }					  
						  ],
						  max:{{$ymax}},
						  opposite:false
							}
						], */
						
						// plotOptions: {
							// series: {
								// label: {
									// connectorAllowed: false
								// },
								// pointStart: 2010
							// },
							// showInLegend:true
						// },
						
						// legend: {
							// title: {
								// text: 'City<br/><span style="font-size: 9px; color: #666; font-weight: normal">(Click to hide)</span>',
								// style: {
									// fontStyle: 'italic'
								// }
							// },
							// layout: 'horizontal',
							// align: 'right',
							// verticalAlign: 'top',
							// x: -10,
							// y: 100,							
							// showInLegend:true
						// },


						/* rangeSelector: {
							
							inputEnabled: false,

							buttons: [
							{
								type: 'hour',
								count: 1,
								text: '1h'
							},
							{
								type: 'day',
								count: 1,
								text: '1day'
							},{
								type: 'day',
								count: 3,
								text: '3d'
							}, {
								type: 'week',
								count: 1,
								text: '1w'
							},{
								type: 'week',
								count: 2,
								text: '2w'
							}, {
								type: 'month',
								count: 1,
								text: '1m'
							},{
								type: 'month',
								count: 2,
								text: '2m'
							}, {
								type: 'month',
								count: 6,
								text: '6m'
							}, {
								type: 'year',
								count: 1,
								text: '1y'
							}, {
								type: 'all',
								text: 'All'
							}],
							selected: 3
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
						}, */
												
						 // tooltip: {
							// formatter: function() {
								// console.log(this.y);
								// return  '<b>Water Level:' + (this.y).toFixed(2) +' mRL</b><br/>Datetime:' +
									// Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							// }
						// }, 
						// showInLegend:true,
						 // plotOptions: {
							 // pie: {
								 // shadow: false,
								 // center: ['50%', '50%']
							 // },
							 // series: {
								 // stacking: 'normal',
							 // },
							 // showInLegend:true
						
						 // },
						
						// plotOptions: {
							// pie: {
								// allowPointSelect: true,
								// cursor: 'pointer',
								// dataLabels: {
									// enabled: false
								// },
								// showInLegend: true
							// }
						// },
						
						
						/*xAxis: {
							plotBands: data2
						}, */
						
						 series: [{
							data: [29.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]
						}, {
							data: [144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4, 29.9, 71.5, 106.4, 129.2],
							showInLegend: true
						}]
						
						// series: [
						// {
							// data: data.wa,
						// },{
							// data: data.wr,
							// showInLegend: true
						// }
							
							
						// ],
						
						/* series: [
						
							{
								name: 'Depth',
								type:	'line',
								// legendIndex:0,
								// showInLegend: true,
								data: data.wa,
								// tooltip: {
									// valueDecimals: 2,
									// formatter: function() {
										// return  '<b>Depth:' + (this.y).toFixed(2) +' wa</b><br/>Datetime:' +
											// Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									// }
								// },
								showInLegend: true,
							},
							{
								name: 'Battery Level',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.bl,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>Battery Level:' + (this.y).toFixed(2) +' bl</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: '3G Signal',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.ss,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' ss</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Velocity',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.vl,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' vl</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Flow',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.wf,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' wf</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Distance',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.m,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' m</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Rainfall',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.ra,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' ra</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Maintenance',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.mt,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' mt</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							},
							{
								name: 'Dist to water',
								type:	'line',
								// legendIndex:0,
								showInLegend: true,
								data: data.wr,
								tooltip: {
									valueDecimals: 2,
									formatter: function() {
										return  '<b>3G Signal:' + (this.y).toFixed(2) +' wr</b><br/>Datetime:' +
											Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
									}
								},
							}
						], */
						
						
						
						// responsive: {
							// rules: [{
								// condition: {
									// maxWidth: 500
								// },
								// chartOptions: {
									// legend: {
										// layout: 'horizontal',
										// align: 'center',
										// verticalAlign: 'bottom'
									// }
								// }
							// }]
						// }
					});
					
				}
			});
		});
		
		function selectStation(id){
			if(parseInt(id)>0){
				var daterange = $('#daterange').val();
				window.location.href = "{{URL::to('display/')}}/"+id+'?onchagnedaterange='+daterange;
			}
			
		}
	</script>
	@endsection