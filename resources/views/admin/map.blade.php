	<?php 

    use App\Models\Station;
    use App\Helper;

    	$allStations = Station::getStation(0,$fields='id,station_id,pub_id,station_name,station_latitude,station_longitude,type');
		$typeArrayprefix = Station::$typeArrayprefix;
    	$allStationsdataset = Station::getStation();

		$allStationsdata = [];
		foreach ($allStationsdataset as $key => $value) {
			$pub_id = $value['pub_id'];
			$allStationsdata[$pub_id] = $value;
		}

	?>

	@extends('admin.layout')
	
	@section('css')
		<style>
		#floating-panel {
		    position: absolute;
		    top: 2%;
		    right: 7%;
		    z-index: 5;
		    background-color: #fff;
		    padding: 5px;
		    border: 1px solid #999;
		    text-align: center;
		    font-family: 'Roboto','sans-serif';
		    line-height: 30px;
		    padding-left: 10px;
		}
		div#legend img,.search-type-cnt img, div#map-canvas img {
		    margin: 5px;
		}
		.checkbox{
		    margin-top: 5px;
		    margin-bottom: 5px;
		}
		.search-text-input-cnt{
			margin: 0;
		}
		</style>
	@endsection
        
	
	@section('content')

        <div class="sidebar left-search-filter-cnt col-sm-4 col-md-3 col-lg-2 ">
            <label class="search-text"> Search</label>
            <p class="search-text-input-cnt">
                <!-- <label>Station</label> -->
                <input type="text" id="search-text-input" class="search-text-input" onkeyup="showFilteredstations(1);" placeholder="Search Station" />
            </p>
            <!-- <label>Types</label> -->
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="0" checked="true" onclick="showFilteredstations(1);"  /> Flow Stations 
                			<img class="logo" src="{{asset('/public/admin/dist/img/river.png')}}" alt="flow">
                    </label>
                </div>
            </div>
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="1" checked="true" onclick="showFilteredstations(1);"  /> Reservior Level 
                			<img class="logo" src="{{asset('/public/admin/dist/img/reservoir.png')}}" alt="flow">
                    </label>
                </div>
            </div>
            <div class="search-type-cnt">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="serach-type" value="2" checked="true" onclick="showFilteredstations(1);" /> Rain Gauge 
                			<img class="logo" src="{{asset('/public/admin/dist/img/rain.png')}}" alt="flow">
                    </label>
                </div>
            </div>                
            <div class="search-stations-list">
                <ul class="list-group" id="filterSearchlistleft">                
	                @foreach($allStations as $key=>$station)
	                <?php 
	                	$type = $station->type;
	                ?>
	                <li class="list-group-item" data-type="{{$type}}" data-station_id="{{$station->station_id}}">
	                    <a href="{{URL::to('display')}}/{{$station->id}}">
	                        <span class="badge pull-right">{{$station->pub_id}}</span>
	                        <?php 
	                        	
	                        ?>
	                        <strong class="">{{$station->station_id}}</strong>
	                        <br/>
	                        {{$station->station_name}}
	                    </a>
	               	</li>
	                @endforeach
               	</ul>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 col-lg-10 no-padding">

			<form method="POST" action=""> <?php /* */ ?>
				
				<div class="col-md-12"  id="map-canvas" style="height:600px;">
		  
				</div>
				<div id="floating-panel">
					<div id="legend" style="">
	                    <table>
	                        <tbody><tr>
	                            <td><strong>Flow</strong></td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_yellow.png')}}"></td>
	                            <td> Maint</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_grey.png')}}"></td>
	                            <td> Halt</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_brown.png')}}"></td>
	                            <td> Idle</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river.png')}}"></td>
	                            <td> &lt;50%</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_yg.png')}}"></td>
	                            <td> &gt;50%</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_orange.png')}}"></td>
	                            <td> &gt;75%</td>
	                            <td><img src="{{asset('/public/admin/dist/img/river_red.png')}}"></td>
	                            <td> &gt;90%</td>
	                        </tr>
	                        <tr>
	                            <td><strong>Reservoir</strong></td>
	                            <td><img src="{{asset('/public/admin/dist/img/reservoir_yellow.png')}}"> </td>
	                            <td>Maint</td>
	                            <td><img src="{{asset('/public/admin/dist/img/reservoir_grey.png')}}"></td>
	                            <td> Halt</td>
	                            <td><img src="{{asset('/public/admin/dist/img/reservoir_brown.png')}}"></td>
	                            <td> Idle</td>
	                            <td><img src="{{asset('/public/admin/dist/img/reservoir.png')}}"></td>
	                            <td> Normal</td>
	                            <td><img src="{{asset('/public/admin/dist/img/reservoir_red.png')}}"></td>
	                            <td> Alert</td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                        </tr>
	                        <tr>
	                            <td><strong>Rain </strong></td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain_yellow.png')}}"></td>
	                            <td> Maint</td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain_grey.png')}}"></td>
	                            <td> Halt</td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain_brown.png')}}"></td>
	                            <td> Idle</td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain.png')}}"></td>
	                            <td> Normal</td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain_yg.png')}}"></td>
	                            <td> Rainy</td>
	                            <td><img src="{{asset('/public/admin/dist/img/rain_red.png')}}"></td>
	                            <td> Alert</td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                            <td></td>
	                        </tr>
	                    </tbody></table>
	                </div>
				</div>
			</form>
		</div>
	
	
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDTbj6TU7S4_8j7Rppf387Fk9KTvA88E1g" type="text/javascript"></script>

		<script language="javascript" type="text/javascript">
		<?php 
			$json_stations = (json_encode($allStations));  
			$all_stations_data = (json_encode($allStationsdata)); 
		?>
		
		var map;
		var time_of_call = 1;
		var markers1 = [];
		var markers2 = [];
		var markers3 = [];
		var markersArray = [];
		var myLatlng = new google.maps.LatLng(1.365709, 103.826037);
		var mapOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var infoWindow = new google.maps.InfoWindow();
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		var allStations = JSON.parse("{{$json_stations}}".replace(/&quot;/g,'"'));
		var all_stations_data = JSON.parse("{{$all_stations_data}}".replace(/&quot;/g,'"'));
		// allStations = (allStations).toString();
		// console.log(all_stations_data);
		
		$(window).resize(function(){

			var windowHeight = $(window).height();
			var subtract_height = (12 / 100) * windowHeight;
			var subtract_height_map = (6 / 100) * windowHeight;
			var needheight = windowHeight - subtract_height;
			var needheight_map = windowHeight - subtract_height_map;
			// console.log(windowHeight);
			// console.log(needheight);
			$("#map-canvas").css('height',needheight_map);
			$("div.search-stations-list").css('height',needheight);
			
		});
		
		$(document).ready(function () {


			var windowHeight = $(window).height();
			var subtract_height = (12 / 100) * windowHeight;
			var subtract_height_map = (6 / 100) * windowHeight;
			var needheight = windowHeight - subtract_height;
			var needheight_map = windowHeight - subtract_height_map;
			// console.log(windowHeight);
			// console.log(needheight);
			$("#map-canvas").css('height',needheight_map);
			$("div.search-stations-list").css('height',needheight);

			maprefresh();
			setInterval(function() {
				
				maprefresh();
			}, 60000); 

		});
		
		var maprefresh = function() 
		{
						
			// var allStations = {{$json_stations}};
			var url = "{{URL::to('../con/detailsJsonall.php')}}"+"";
			$.post(url,{all_sid:allStations}, function(result,textStatus) { 
			
				// $('.total').text(data.total);
				// $('.percentage90').text(data.percentage90);
				// $('.percentage75').text(data.percentage75);
				// $('.percentage50').text(data.percentage50);
				// $('.maintenance').text(data.maintenance);
				// console.log(data);
				var data = result.data;
				var location;
				$.each(data, function (key, val) {


					var station_name = val.station_id+" ["+val.pub_id+"]"+val.station_name;
					if(time_of_call==1){
						addMarker(val.station_latitude,val.station_longitude,station_name,val.image,val.type,val.station_id);
					}
					if(val.type==0){

						var invertlevel = all_stations_data[val.pub_id].invertlevel;


						var wh = val.wh || '0.00';
						var vl = val.vl || '0.00';
						var lvl = val.lvl || '0.00';
						var fl = val.fl || '0.00';
						var ts = val.ts || '';

						lvl = lvl+invertlevel;

						var html = "<b> "+val.station_id+" Station Name: " + val.station_name + " - "+val.pub_id+"</b> <br/> Level (mRL): " + lvl + "<br/>" + "Depth (m) :"+ wh+"<br/>Velocity (m/s) :"+vl+"<br/>Flow (m^3/s) :"+fl+"<br/>Date & Time: " + ts ;
					}else if(val.type==1){
						var waterlevel = val.waterlevel || '0.00';
						var ts = val.ts || '';
						var html = "<b> "+val.station_id+" Station Name: " + val.station_name + " - "+val.pub_id+"</b> <br/> Water Level (m): " + waterlevel+"<br/>Date & Time: " + ts ;
					}else{
						var ra = val.ra || '0.00';
						var ts = val.ts || '';
						var html = "<b> "+val.station_id+" Station Name: " + val.station_name + " - "+val.pub_id+"</b> <br/> Rainfall (mm): " + ra +"<br/>Date & Time: " + ts ;
					}

					// var html = '<div class="container" style="width: 400px"><div class="panel panel-primary"><div class="panel-heading"><a href="'+"{{URL::to('display')}}/"+val.id+'"><span class="badge pull-right">'+val.stationID+'</span></a><strong>RL7</strong><br>'+ val.stationname +'</div><div class="panel-body map-panel"><table class="table"><tbody><tr><td>Water Level(m)</td><td>'+ val.waterlevel_meter+'</td></tr></tbody></table></div><div class="panel-footer"><strong style="text-align: right">Last Update: '+ val.datetime +'</strong><span class="pull-right"><a href="'+"{{URL::to('display')}}/"+val.id+'">Realtime data</a></span></div></div></div>';

								
					(function(marker, val) 
					{
						// Attaching a click event to the current marker
						google.maps.event.addListener(marker, "mouseover", function(e) 
						{
							infoWindow.setContent(html);
							infoWindow.open(map, marker);
						});
						
						google.maps.event.addListener(marker, "click", function(e) 
						{
							window.location = "{{URL::to('display')}}/"+val.id;
						});
						
						
					})(marker, val);					
					
				}); 
				// if(parseInt(station_id)>0){
				// 	map.setCenter({lat: data.lat, lng: data.lon});
				// 	map.setZoom(20);
				// }
				time_of_call++;

			},"JSON");
			
			function addMarker(lat,lng,tit,image,type,station_id) 
			{
				if(type==0){
					var icon_img = "../public/admin/dist/img/river.png";
				}else if(type==1){
					var icon_img = "../public/admin/dist/img/reservoir.png";
				}else{
					var icon_img = "../public/admin/dist/img/rain.png";
				}
				
				/*if(image == 'red')

				{
					var icon_img = "../public/admin/image/red.png";
				}
				
				else if (image == 'green')
				{
					var icon_img = "../public/admin/image/green.png";
				}
				else if (image == 'yellow')
				{
					var icon_img = "../public/admin/image/yellow.png";
				}
				else if (image == 'black')
				{
					var icon_img = "../public/admin/image/black.png";
				}
				else
				{
					var icon_img = "../public/admin/dist/img/river.png";
				}*/
				
				
				marker = new google.maps.Marker(
				{
					
					position: new google.maps.LatLng(lat,lng),
					map: map,
					title:tit,
					icon: icon_img

				});

				markersArray[[station_id]] = marker;

			}
			
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (var i = 0; i < markersArray.length; i++) {
				  markersArray[i].setMap(map);
				}
			}

			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
		}
		
		function selectStation(id){
			if(parseInt(id)<=0 || id==''){
				id = 0;
			}
			window.location.href = "{{URL::to('map/')}}/"+id;
		}
		function zoomTo(level) {
			google.maps.event.addListener(map, 'zoom_changed', function () {
				zoomChangeBoundsListener = google.maps.event.addListener(map, 'bounds_changed', function (event) {
					if (this.getZoom() > level && this.initialZoom == true) {
						this.setZoom(level);
						this.initialZoom = false;
					}
					google.maps.event.removeListener(zoomChangeBoundsListener);
				});
			});
		}
		
		</script>
		
			
	@endsection
	
	
	@section('js')
	
	@endsection