
@extends('admin.layout')

@section('css')
<style>
	#frame{
		width: 100%;
	}
</style>

@endsection

@section('content')
		
		
       <div class=" main-cnt scnt">
		
		</div>
        

@endsection

@section('js')

	<script src="https://code.highcharts.com/stock/highstock.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script>
		$(document).ready(function () {
			
			/* var winheight = $( window ).height();
			var percentage10 = (winheight/100) * 15;
			
			frameHeight = parseFloat(winheight)-parseFloat(percentage10);
			$('#frame').css('height',(frameHeight)+'px'); */
			refreshcontent(); 
			$(document).ready(function () {
				setInterval(function () {
					refreshcontent(); 
				}, 60000);
			});
			
			
		});
		
		var refreshcontent = function(){
			
			$.get("{{URL::to('wlsummary50').'?daterange='.$daterange}}"+'&status='+status,function(result){
				
				$('.scnt').html(result);
			});
			
		}
		
		function SubmitForm(status) { 
			$.get("{{URL::to('wlsummary50').'?daterange='.$daterange}}"+'&status='+status,function(result){
				
				$('.scnt').html(result);
				
			});
		}
	</script>
	

@endsection
