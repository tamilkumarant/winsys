	<?php
		require "../top_header/map_header.php"; // top header
		//require "code_behind/location_mobile_script.php"; // display script - mobile/PC
	?>
  
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp" type="text/javascript"></script>
	<script language="javascript" type="text/javascript">

	google.maps.event.addDomListener(window, 'load', function() 
	{
		var map;
		var markersArray = [];
		var myLatlng = new google.maps.LatLng(1.365709, 103.826037);
		var mapOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var infoWindow = new google.maps.InfoWindow();
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		$.getJSON('../code_behind/mapdata.php', function(data)
		{ 
		//alert("Hi");
		var location;
			$.each(data, function (key, val) 
			{
			addMarker(val.lat,val.lon,val.stationname,val.image);
			var html = "<b> Station Name: " + val.stationname + "</b> <br/> Station ID: " + val.stationID + "<br/>" +"Latitude: " + val.lat + "<br/>" +"Longitude :"+ val.lon;
			
			//alert(html);
			
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
						//window.location = 'dashboard.php';
						//window.location = 'wlinfo.php?device_id=' + val.stationID +'';
					});
					
					
				})(marker, val);
		
			}) 
		})
		
		
		function addMarker(lat,lng,tit,image) 
		{
			
			if(image == 'red')
			{
				var icon_img = "../image/red.png";
			}
			
			else if (image == 'green')
			{
				var icon_img = "../image/green.png";
			}
			else if (image == 'yellow')
			{
				var icon_img = "../image/yellow.png";
			}
			else if (image == 'black')
			{
				var icon_img = "../image/black.png";
			}
			else
			{
				var icon_img = "../image/green.png";
			}
			
			
			marker = new google.maps.Marker(
			{
				
				position: new google.maps.LatLng(lat,lng),
				map: map,
				title:tit,
				icon: icon_img
			});
			markersArray.push(marker);
		}
	});

	</script>
	
	<?php 
		include('../dbconnection/dbconnection_open.php');
		if(checkAuth(6,'view')){ 
	?>
    <!-- Content Wrapper. Contains page content -->
    <div  id="map-canvas" class="content-wrapper" style="height:600px;">
      
    </div><!-- /.content-wrapper -->
		<?php } ?>
	
	<?php
		require "../include/footer.php"; // common header
	?>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../pub/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../pub/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="../pub/plugins/slimScroll/jquery.slimScroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="../pub/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../pub/dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>