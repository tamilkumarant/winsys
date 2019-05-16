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
		.table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
		    border-top: 0;
		}
		.table-bordered>thead>tr>th, .table-bordered>thead>tr>td {
		    border-bottom-width: 2px;
		}
		.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
		    border: 1px solid #504040;
		}
		</style>
	@endsection
        
	
	@section('content')

        

        <div class="col-sm-12 col-md-12 col-lg-12 table-cnt">
        	<h3>Flow Stations</h3>
			<table class="customTable1 customTable table table-bordered table-striped">

			</table>
			<h3>Reservoir Level Stations</h3>			
			<table class="customTable2 customTable table table-bordered table-striped">

			</table>
			<h3>Rain Gauge Stations</h3>			
			<table class="customTable3 customTable table table-bordered table-striped">

			</table>			

		</div>
	
		

		<?php 	$json_stations = (json_encode($allStations)); 
				$allStationsdata = (json_encode($allStationsdata)); 

		?>


		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script language="javascript" type="text/javascript">
			

		$(document).ready(function () {
			$('.table-cnt').hide();

			maprefresh();
			setInterval(function() {
				
				maprefresh();
			}, 60000); 

		});
		
		var maprefresh = function() 
		{
			var allStations = JSON.parse("{{$json_stations}}".replace(/&quot;/g,'"'));
			var all_stations_data = JSON.parse("{{$allStationsdata}}".replace(/&quot;/g,'"'));
			// console.log(all_stations_data);	
			var url = "{{URL::to('../con/detailsJsonall.php')}}"+"";
			$.post(url,{all_sid:allStations}, function(result,textStatus) { 

				var data = result.data;
				var location;
				var content1 = "<thead><tr> <th>Station ID</th><th>PUB ID</th><th>Station Name</th><th>50% Level</th><th>75% Level</th><th>90% Level</th><th>100% Level</th><th>Operation Level</th> <th>Level (mRL)</th><th>Depth (m)</th> <th>Velocity (m/s)</th> <th>Flow rate (m3/s)</th>    <th>Latest Update</th> </tr></thead>";
				var content2 = "<thead><tr> <th>Station ID</th><th>PUB ID</th><th>Station Name</th><th>Alarm (m)</th><th>Water_Level (mRL)</th><th> Distance (m)</th><th>Latest Update</th> </tr></thead>";
				var content3 = "<thead><tr> <th>Station ID</th><th>PUB ID</th><th>Station Name</th><th>Alarm (m)</th><th>Rainfall (mm)</th><th>Latest Update</th> </tr></thead>";
				$.each(data, function (key, val) {

					var graphUrl = "{{URL::to('display')}}/"+val.id;

					if(val.type==0){

						var invertlevel = all_stations_data[val.pub_id].invertlevel;
						var copelevel = all_stations_data[val.pub_id].copelevel;
						var operationlevel = all_stations_data[val.pub_id].operationlevel;

						var wh = val.wh || 0;
						var vl = val.vl || 0;
						var lvl = val.lvl || 0;
						var fl = val.fl || 0;
						var ts = val.ts || '';

						lvl = lvl+invertlevel;

						// percent50 = 0;
						// if(invertlevel!=0){
							var percent50 = ((copelevel-invertlevel)/2)+invertlevel;
						// }
						// percent75 = 0;
						// if(invertlevel!=0){
							var percent75 = ((copelevel-invertlevel)/4)*3+invertlevel;
						// }
						// percent90 = 0;
						// if(invertlevel!=0){
							var percent90 = ((copelevel-invertlevel)/10)*9+invertlevel;
						// }
						// percent100 = 0;
						// if(invertlevel!=0){
							var percent100 = copelevel;
						// }

						// var v50 = [(Cope level – Invert level)/ 2] + Invert level;

						wh = parseFloat(wh);
						wh = (wh>0) ? wh.toFixed(3) : '0.000' ;
						
						vl = parseFloat(vl);
						vl = (vl>0) ? vl.toFixed(3) : '0.000' ;
						
						fl = parseFloat(fl);
						fl = (fl>0) ? fl.toFixed(3) : '0.000' ;
						
						lvl = parseFloat(lvl);
						lvl = (lvl>0) ? lvl.toFixed(3) : '0.000' ;

						operationlevel = parseFloat(operationlevel);
						operationlevel = (operationlevel>0) ? operationlevel.toFixed(3) : '0.000' ;
						
						percent100 = parseFloat(percent100);
						percent100 = (percent100>0) ? percent100.toFixed(3) : '0.000' ;
						
						percent90 = parseFloat(percent90);
						percent90 = (percent90>0) ? percent90.toFixed(3) : '0.000' ;
						
						percent75 = parseFloat(percent75);
						percent75 = (percent75>0) ? percent75.toFixed(3) : '0.000' ;

						percent50 = parseFloat(percent50);
						percent50 = (percent50>0) ? percent50.toFixed(3) : '0.000' ;

						/*percent50 = (percent50>0) ? percent50.toFixed(3) : '0.000' ;
						percent75 = percent75.toFixed(3);
						percent90 = percent90.toFixed(3);
						percent100 = percent100.toFixed(3);
						operationlevel = operationlevel.toFixed(3);
						lvl = lvl.toFixed(3);
						// wh = (wh>0) ? wh.toFixed(3) : ''0.000'' ;
						// wh = wh.toFixed(3);
						// vl = vl.toFixed(3);
						// fl = fl.toFixed(3);*/

						content1 += "<tr> <td>"+val.station_id+"</td><td><a href='"+graphUrl+"'>"+val.pub_id+"</a></td><td>"+val.station_name+"</td><td>"+percent50+"</td><td>"+percent75+"</td><td>"+percent90+"</td><td>"+percent100+"</td><td>"+operationlevel+"</td> <td>"+lvl+"</td><td>"+wh+"</td> <td>"+vl+"</td> <td>"+fl+"</td>    <td>"+ts+"</td> </tr>" ;

							// <b> "+val.station_id+" Station Name: " + val.station_name + " - "+val.pub_id+"</b> <br/> Level (mRL): " + lvl + "<br/>" + "Deptd (m) :"+ wa+"<br/>Velocity (m/s) :"+vl+"<br/>Flow (m^3/s) :"+wf+"<br/>Date & Time: " + ts

					}else if(val.type==1){
						var waterlevel = val.waterlevel || 0;
						var m = val.m || 0;
						var ts = val.ts || '';
						var al = (waterlevel>=50) ? 'ON':'OFF';

						var invertlevel = all_stations_data[val.pub_id].invertlevel;
						
						waterlevel = parseFloat(waterlevel)+parseFloat(invertlevel);


						waterlevel = parseFloat(waterlevel);
						waterlevel = (waterlevel>0) ? waterlevel.toFixed(3) : '0.000' ;
						m = parseFloat(m);
						m = (m>0) ? m.toFixed(3) : '0.000' ;

						content2 += "<tr> <td>"+val.station_id+"</td><td><a href='"+graphUrl+"'>"+val.pub_id+"</a></td><td>"+val.station_name+"</td><td>"+al+"</td><td>"+waterlevel+"</td><td> "+m+"</td><td>"+ts+"</td> </tr></tdead>";
						// var html = "<b> "+val.station_id+" Station Name: " + val.station_name + " - "+val.pub_id+"</b> <br/> Water Level (m): " + waterlevel+"<br/>Date & Time: " + ts ;
					}else{
						var ra = val.ra || 0;
						var ts = val.ts || '';
						var al = (ra>=50) ? 'ON':'OFF';

						ra = parseFloat(ra);
						ra = (ra>0) ? ra.toFixed(3) : '0.000' ;

						content3 += "<tr> <td>"+val.station_id+"</td><td><a href='"+graphUrl+"'>"+val.pub_id+"</a></td><td>"+val.station_name+"</td><td>"+al+"</td><td>"+ra+"</td><td>"+ts+"</td> </tr></tdead>";
					}

				});

				$('.customTable1').html(content1); 
				$('.customTable2').html(content2); 
				$('.customTable3').html(content3); 
				// $('.customTable').DataTable({
				// 	"paging": true,
				// 	"lengthChange": true,
				// 	"searching": true,
				// 	"ordering": true,
				// 	"sorting":[],
				// 	"info": true,
				// 	"autoWidth": false,
				// 	"aaSorting": []
				// });

				$('.table-cnt').show();

			}, "JSON");
			
		}
		
		
		
		</script>
		
			
	@endsection
	
	
	@section('js')
	
	@endsection