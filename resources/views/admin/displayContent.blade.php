	<?php 
	
		use App\Helper;
		use App\Models\Station;

		$waterlever_mrl = isset($lastRawdata->waterlever_mrl)?($lastRawdata->waterlever_mrl):"N/A";
		$datetime = isset($lastRawdata->datetime)?($lastRawdata->datetime):date('Y-m-d H:i');
		$battery_voltage = isset($lastRawdata->battery_voltage)?($lastRawdata->battery_voltage):"N/A";


    	$allStations = Station::getStation();
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
		#stationInfo .txtright label{
			color: #7b7c7d;
		}
		/*#stationMapcontent {
        	height: 400px;  
        	width: 100%;  
       	}*/
		</style>
	@endsection
	
	
	@section('content')

		<div class="sidebar left-search-filter-cnt col-sm-4 col-md-3 col-lg-2 ">
            <label class="search-text"> Search</label>
            <p class="search-text-input-cnt">
                <!-- <label>Station</label> -->
                <input type="text" id="search-text-input" class="search-text-input" onkeyup="showFilteredstations('');" placeholder="Search Station" />
            </p>
            <!-- <label>Types</label> -->
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="0" checked="true" onclick="showFilteredstations('');"  /> Flow Stations 
                			<img class="logo" src="{{asset('/public/admin/dist/img/river.png')}}" alt="flow">
                    </label>
                </div>
            </div>
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="1" checked="true" onclick="showFilteredstations('');"  /> Reservior Level 
                			<img class="logo" src="{{asset('/public/admin/dist/img/reservoir.png')}}" alt="flow">
                    </label>
                </div>
            </div>
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="2" checked="true" onclick="showFilteredstations('');" /> Rain Gauge 
                			<img class="logo" src="{{asset('/public/admin/dist/img/rain.png')}}" alt="flow">
                    </label>
                </div>
            </div>                
            <div class="search-stations-list">
                <ul class="list-group" id="filterSearchlistleft">                
	                @foreach($allStations as $key=>$stationVal)
	                <?php 
	                	$type = $stationVal->type;
	                ?>
	                <li class="list-group-item" data-type="{{$type}}" data-station_id="{{$stationVal->station_id}}">
	                    <a href="{{URL::to('display')}}/{{$stationVal->id}}">
	                        <span class="badge pull-right">{{$stationVal->pub_id}}</span>
	                        <?php 
	                        	
	                        ?>
	                        <strong class="">{{$stationVal->station_id}}</strong>
	                        <br/>
	                        {{$stationVal->station_name}}
	                    </a>
	               	</li>
	                @endforeach
               	</ul>
            </div>
        </div>


	 	<div class="col-sm-8 col-md-9 col-lg-10 no-padding">
		
	        <section class="content">
				<div class="row">
	            <div class="col-lg-3 col-xs-6">
	              <!-- small box -->
	              <div class="small-box bg-aqua">
	                <div class="inner">
	                  <p class="box1"><sup style="font-size: 20px"></sup></p>
	                  <p class="box1lbl"></p>
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
	                  <p class="box2"><sup style="font-size: 20px"></sup></p>
	                  <p class="box2lbl"></p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-arrow-graph-up-right"></i>
	                </div>
	              </div>
	            </div><!-- ./col -->
	            <div class="col-lg-3 col-xs-6">
	              <!-- small box -->
	              <div class="small-box bg-yellow">
	                <div class="inner">
	                  <p class="box3"><sup style="font-size: 20px"></sup></p>
	                  <p class="box3lbl"></p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-clock"></i>
	                </div>
	              </div>
	            </div><!-- ./col -->
	            <div class="col-lg-3 col-xs-6">
	              <!-- small box -->
	              <div class="small-box bg-red">
	                <div class="inner">
	                  <p class="box4"><sup style="font-size: 20px"></sup></p>
	                  <p class="box4lbl"></p>
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
					<div id="info" style="col-md-12" style="padding:5px 0;">	
						<div class="col-md-1 no-padding mtop10 txtright">
							<span>Station Name</span>
						</div>	
						<div class="col-md-4 col-sm-12 no-padding mtop5">
							<select name="station_id" class="form-control station_id" required onchange="selectStation(this.value);" >
								<option value="">Select Station</option>
								@foreach($stations as $key=>$val)
								<option value="{{$val->id}}"  @if($val && $val->id==$station->id){{'selected'}} @endif >{{$val->station_id.' - '.$val->pub_id.' - '.$val->station_name}}</option>
								@endforeach
							</select>
						</div>			
						<div class="col-md-6 col-sm-12  no-padding">						
							<div class="nav-tabs-custom col-md-12">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#chartCnt" data-toggle="tab">Chart</a></li>
									<li><a href="#tableCnt" data-toggle="tab">Table</a></li>
									<li><a href="#stationInfo" data-toggle="tab">Station Info</a></li>
									<li><a href="#stationLiveCnt" data-toggle="tab">Station Image</a></li>
									<li><a href="#stationMap" data-toggle="tab">Map</a></li>
								</ul>
							</div>
						</div>
						<div style="clear:both;"></div>
					</div> <?php /* */ ?>
					<?php /* <div class="col-md-12 marginh10">
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
					</div> */ ?>
					<div class="col-md-12  no-padding nav-tabs-custom">
						<div class="nav-tabs-custom">	
							<div class="tab-content">
								<div class="active tab-pane" id="chartCnt">
									
								</div>
								<div class="tab-pane" id="tableCnt">
									<div class="box-body">
										<table class="customTable table table-bordered table-striped">
											<?php /*
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
												
											</tbody> */ ?>
										</table>
									</div>
								</div>
								<div class="tab-pane" id="stationInfo">	
									<div class="row">							
										<?php /* <div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Name</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->station_name}}</label>
											</div>
										</div> */	?>	


										<div class="col-lg-12">
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
										<div class="clear"></div>

										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>StationID</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->station_id}}</label>
											</div>
										</div>							
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>PUB_ID</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->pub_id}}</label>
											</div>
										</div>							
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>StationtType</label>
											</div>
											<div class="col-lg-3">
												<label><?php echo Station::flowType($station->type); ?></label>
											</div>
										</div>							
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Location</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->location}}</label>
											</div>
										</div>								
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Lattitude</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->station_latitude}}</label>
											</div>
										</div>							
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Longitude</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->station_longitude}}</label>
											</div>
										</div>							
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Alarm level</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->alarmlevel}}</label>
											</div>
										</div>						
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Copelevel</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->copelevel}}</label>
											</div>
										</div>					
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Operationlevel</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->operationlevel}}</label>
											</div>
										</div>					
										<div class="col-lg-12">
											<div class="col-md-offset-3 col-md-3 txtright">
												<label>Invertlevel</label>
											</div>
											<div class="col-lg-3">
												<label>{{$station->invertlevel}}</label>
											</div>
										</div>


									</div>
									<div class="clear"></div>
								</div>
								<div class="tab-pane" id="stationLiveCnt">	
									@if($station->image)
										<img src="{{URL::to('public/stations/'.$station->image)}}" width="100%" height="100%" />
									@endif
								</div>
								<div class="tab-pane" id="stationMap">
									<div id="stationMapcontent"></div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		
		</div>
		
			
	@endsection


	
	
	@section('js')


	<!-- <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtc8TPG-j3G6jXWpmyJvFg9QbEBhxLRuM&callback=initMap">
    </script> -->
	<script>

		if (typeof google === 'object' && typeof google.maps === 'object') {
        	// handleApiReady();
	    } else {
	        var script = document.createElement("script");
	        script.type = "text/javascript";
	        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDTbj6TU7S4_8j7Rppf387Fk9KTvA88E1g&callback=initMap";
	        document.body.appendChild(script);
	    }

		$(document).ready(function () {

			
			var windowHeight = $(window).height();
			var subtract_height = (12 / 100) * windowHeight;
			var subtract_height_map = (20 / 100) * windowHeight;
			var needheight = windowHeight - subtract_height;
			var needheight_map = windowHeight - subtract_height_map;
			// console.log(windowHeight);
			// console.log(needheight);
			$("#chartCnt,#tableCnt,#stationInfo,#stationLiveCnt,#stationMap,#stationMapcontent").css('height',needheight_map);
			$("div.search-stations-list,.tab-content").css('height',needheight);

			function initMap() {} // now it IS a function and it is in global
		
			// $('.customTable').DataTable({
				// "paging": true,
				// "lengthChange": true,
				// "searching": true,
				// "ordering": true,
				// "sorting":[],
				// "info": true,
				// "autoWidth": false,
				// "aaSorting": []
			// });
			$('#daterange').daterangepicker({
				timePicker: true, 
				timePickerIncrement: 1, 
				format: 'YYYY/MM/DD HH:mm',
			});

			
						
		});

		$(window).resize(function(){

			var windowHeight = $(window).height();
			var subtract_height = (12 / 100) * windowHeight;
			var subtract_height_map = (20 / 100) * windowHeight;
			var needheight = windowHeight - subtract_height;
			var needheight_map = windowHeight - subtract_height_map;
			// console.log(windowHeight);
			// console.log(needheight);
			$("#chartCnt,#tableCnt,#stationInfo,#stationLiveCnt,#stationMap,#stationMapcontent").css('height',needheight_map);
			$("div.search-stations-list,.tab-content").css('height',needheight);
			
		});

		// Initialize and add the map
		function initMap() {
		  // The location of Uluru
		  var uluru = { lat: {{$station->station_latitude}}, lng: {{$station->station_longitude}} };
		  // The map, centered at Uluru
		  var map = new google.maps.Map(
		      document.getElementById('stationMapcontent'), {zoom: 17	, center: uluru});
		  // The marker, positioned at Uluru
		  var marker = new google.maps.Marker({position: uluru, map: map});
		}

		
		$(function(){
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});
				
			var formData = $('form').serialize();
			
			// var url = "{{URL::to('get-chart-rawdata')}}";
			// var url = "http://52.77.209.104/con/detailsJsonnew.php?sid="+"{{$station->pub_id}}"+"&flowtype="+"{{$station->type}}"+"&invertlevel="+"{{$station->invertlevel}}";
			var url = "{{URL::to('../con/detailsJsonnew.php')}}"+"?sid="+"{{$station->pub_id}}"+"&flowtype="+"{{$station->type}}"+"&invertlevel="+"{{$station->invertlevel}}";
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
					var data = result.data;
					var maintenance = result.maintenance;
					var tbl = result.table_data;
					var flowtype = result.flowtype;
					var box = result.box;
					var series = [];
					var yax = [];
					if(flowtype==0){

						$('.box1lbl').html('Flow (m3/s)');
						$('.box1').html(box[0].fl);
						$('.box2lbl').html('Water Level (mRL)');
						$('.box2').html(box[0].lvl);
						$('.box3lbl').html('Datetime');
						$('.box3').html(box[0].ts);
						$('.box4lbl').html('Battery Voltage');
						$('.box4').html(box[0].bl);

						$(function () {
								var content = '';
								content += "<thead><tr> <th>Time</th>  <th>Depth (m)</th>  <th>Level (mRL)</th> <th>Flow rate (m3/s)</th>  <th>Velocity (m/s)</th>  <th>Status</th> </tr></thead>";
							for (var i = 0; i < result.table_data.length; i++) {
								content += '<tr>';
								content += '<td>' + tbl[i].ts + '</td>';
								content += '<td>' + tbl[i].wh + '</td>';
								content += '<td>' + tbl[i].lvl + '</td>';
								content += '<td>' + tbl[i].fl + '</td>';
								content += '<td>' + tbl[i].vl + '</td>';
								if(tbl[i].mt){
									content += '<td>' + 'Maintenance' + '</td>';
								}else{									
									content += '<td>' + 'Running' + '</td>';
								}
								content += '</tr>';
							}
							$('.customTable').html(content); 
							$('.customTable').DataTable({
								"paging": true,
								"columnDefs" : [{"targets":0, "type":"date-eu"}],
								"aaSorting": [[ 0, "desc" ]], //or asc 
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"sorting":[],
								"info": true,
								"autoWidth": false,
								// "aaSorting": []
							});
					   });  

					 	yax = [{ // Primary yAxis
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        },
					        title: {
					            text: 'Depth (m)',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        },		        
					        opposite: false

					    }, { // Secondary yAxis
					        // gridLineWidth: 0,
					        title: {
					            text: 'Level (mRL)',
					            style: {
					                color: Highcharts.getOptions().colors[1]
					            }
					        },
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[1]
					            }
					        },					        
					        opposite: false

					    }, { // Tertiary yAxis
					        // gridLineWidth: 0,
					        title: {
					            text: 'Flow rate (m3/s)',
					            style: {
					                color: Highcharts.getOptions().colors[2]
					            }
					        },
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[2]
					            }
					        },
					        opposite: true
					    }, { // Tertiary yAxis
					        // gridLineWidth: 0,
					        title: {
					            text: 'Velocity (m/s)',
					            style: {
					                color: Highcharts.getOptions().colors[3]
					            }
					        },
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[3]
					            }
					        },
					        opposite: true
					    }];

					   series = [						
								{
									name: 'Depth (m)',
									type:	'line',
									data: data.wh,
									showInLegend: true,
									yAxis: 0
								},					
								{
									name: 'Level (mRL)',
									type:	'line',
									data: data.lvl,
									showInLegend: true,
									yAxis: 1
								},					
								{
									name: 'Flow rate (m3/s)',
									type:	'line',
									data: data.fl,
									showInLegend: true,
									yAxis: 2
								},					
								{
									name: 'Velocity (m/s)',
									type:	'line',
									data: data.vl,
									showInLegend: true,
									yAxis: 3
								}
							];
					} else if(flowtype==1){


						$('.box1lbl').html('Water Level (mRL)');
						$('.box1').html(box[1].waterlevel);
						$('.box2lbl').html('Depth (m)');
						$('.box2').html(box[1].m);
						$('.box3lbl').html('Datetime');
						$('.box3').html(box[1].ts);
						$('.box4lbl').html('Battery Voltage');
						$('.box4').html(box[1].bl);

						$(function () {
								var content = '';
								content += "<thead><tr> <th>Time</th>  <th>Water Level (mRL)</th>  <th>Depth (m)</th>  <th>Status</th> </tr></thead>";
							for (var i = 0; i < result.table_data.length; i++) {
								content += '<tr>';
								content += '<td>' + tbl[i].ts + '</td>';
								content += '<td>' + tbl[i].waterlevel + '</td>';
								content += '<td>' + tbl[i].m + '</td>';
								if(tbl[i].mt){
									content += '<td>' + 'Maintenance' + '</td>';
								}else{									
									content += '<td>' + 'Running' + '</td>';
								}
								content += '</tr>';
							}
							$('.customTable').html(content); 
							$('.customTable').DataTable({
								"paging": true,
								"columnDefs" : [{"targets":0, "type":"date-eu"}],
								"aaSorting": [[ 0, "desc" ]], //or asc 
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"sorting":[],
								"info": true,
								"autoWidth": false,
								// "aaSorting": []
							});
					   });


					 	yax = [{ // Primary yAxis
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        },
					        title: {
					            text: 'Water Level (mRL)',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        },		        
					        opposite: false

					    }, { // Secondary yAxis
					        // gridLineWidth: 0,
					        title: {
					            text: 'Depth (m)',
					            style: {
					                color: Highcharts.getOptions().colors[1]
					            }
					        },
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[1]
					            }
					        },					        
					        opposite: true

					    }];

					   series = [						
							{
								name: 'Water Level (mRL)',
								type:	'line',
								data: data.waterlevel,
								showInLegend: true,
								yAxis: 0
							},					
							{
								name: 'Depth (m)',
								type:	'line',
								data: data.m,
								showInLegend: true,
								yAxis: 1
							}
						];   
					}else if(flowtype==2){

						var mt = (box[2].mt==1) ? 'Maintenance' : 'Running';

						$('.box1lbl').html('Rainfall (mm)');
						$('.box1').html(box[2].ra);
						$('.box2lbl').html('Status');
						$('.box2').html(mt);
						$('.box3lbl').html('Datetime');
						$('.box3').html(box[2].ts);
						$('.box4lbl').html('Battery Voltage');
						$('.box4').html(box[2].bl);

						$(function () {
								var content = '';
								content += "<thead><tr> <th>Time</th>  <th>Rainfall (mm)</th> <th>Total Rainfall Today </th>   <th>Status</th> </tr></thead>";
							for (var i = 0; i < result.table_data.length; i++) {
								content += '<tr>';
								content += '<td>' + tbl[i].ts + '</td>';
								content += '<td>' + tbl[i].ra + '</td>';
								content += '<td>' + tbl[i].rd + '</td>';
								if(tbl[i].mt){
									content += '<td>' + 'Maintenance' + '</td>';
								}else{									
									content += '<td>' + 'Running' + '</td>';
								}
								content += '</tr>';
							}
							$('.customTable').html(content); 
							$('.customTable').DataTable({
								"paging": true,
								"columnDefs" : [{"targets":0, "type":"date-eu"}],
								"aaSorting": [[ 0, "desc" ]], //or asc 
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"sorting":[],
								"info": true,
								"autoWidth": false,
								// "aaSorting": []
							});
					   });



					 	yax = [{ // Primary yAxis
					        labels: {
					            format: '{value}',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        },
					        title: {
					            text: 'Rainfall (mm)',
					            style: {
					                color: Highcharts.getOptions().colors[0]
					            }
					        }		        
					       // opposite: false

					    }];

					   series = [						
							{
								name: 'Rainfall (mm)',
								type:	'line',
								data: data.ra,
								showInLegend: true,
								yAxis: 0
							}
						];  
					   
					}
					
					
					
					 Highcharts.stockChart('chartCnt', {
						chart: {
							zoomType: 'x',	
							type: 'arearange',
						},
						legend: {
							enabled: true,
							align: 'right',
							backgroundColor: '#FCFFC5',
							borderColor: 'black',
							borderWidth: 1,
							layout: 'horizontal',
							verticalAlign: 'top',
							y: 0,
							shadow: false
						},
								
						yAxis:yax,

						rangeSelector: {
							
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
						},
						
						tooltip: {
							formatter: function() {
							  var s = Highcharts.dateFormat('%A %e-%b -%Y %H:%M',new Date(this.x));
							  $.each(this.points, function(i, point) {
								s += '<br /><span style="color:' + this.series.color + '">' +
									 point.series.name + '</span>: ' + point.y.toFixed(3);
							  });
							  return s;
							}
						},


						xAxis: {
							plotBands: maintenance
						},
	
						series:series,
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