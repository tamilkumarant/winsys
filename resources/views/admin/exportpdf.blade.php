<?php

	


?>


<!DOCTYPE html>
<html>
<head>
	<style type="text/css">


		/*html,body,div,span,header,section,footer,main,ul,ol,li,input,a,table,label,tr,th,td,h1,h2,h3,h4,h5,h6,img{
			margin: 0;
			padding: 0;
			font-family: verdana;
			color:#262626;
			}

		body {
			margin: 0 auto;
			max-width: 100%;
			font-family: verdana;
			font-style: normal;
			}*/
		p {
			margin: 10px;
			padding: 0;
		}

    </style>
</head>
	<body>

		@foreach($allStations as $key=>$stations)

			<?php 
				$image = $stations['imgpath'];
			?>

			<div>
				<h3 style="text-align: center;">{{$stations['station_id']}}</h3>
				<h3 style="text-align: center;">{{$stations['station_name']}}</h3>
				<img src="{{public_path().($image)}}" width="100%" height="400px" />
				<p><label>Cope Level(mRl):</label><label style="font-weight: 800"> {{$stations['copelevel']}}</p>
				<p><label>Operation Level(mRl):</label><label style="font-weight: 800"> {{$stations['operationlevel']}}</label></p>
				<p><label>Invert lLevel(mRl):</label><label style="font-weight: 800"> {{$stations['invertlevel']}}</label></p>
				<p><label>Min:</label><label style="font-weight: 800"> {{$stations['min']}}</label></p>
				<p><label>Max:</label><label style="font-weight: 800"> {{$stations['max']}}</label></p>
			</div>

		@endforeach

	</body>
</html>
