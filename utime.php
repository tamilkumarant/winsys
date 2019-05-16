	<?php

// set default timezone
//date_default_timezone_set('Europe/Berlin');

date_default_timezone_set('Asia/Singapore');
//$currentdate = date('Y-m-d H:i:s', time());

// timestamp
//$timestamp = 1496668720955;

// output
//echo date('Y-m-d H:i:s',$timestamp);
//echo date('c',$timestamp);

$timestamp=1496668720955;
echo date('Y-m-d H:i:s', $timestamp/1000);

		
	?>

