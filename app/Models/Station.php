<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Station extends Model {

	protected $table = 'bwl_station';

	public static $typeArray = [ 0 =>'Flow Stations',1 =>'Reservior Level',2 =>'Rain Gauge' ];
	public static $typeArrayprefix = [ 0 =>'F',1 =>'RL',2 =>'RG' ];
    
	protected $fillable = [
		'station_id',
		'pub_id',
		'station_name',
		'station_latitude',
		'station_longitude',
		'project_id',
		'copelevel',
		'invertlevel',
		'height',
		'maintenance',
		'operationlevel',
		'criticallevel',
		'offset_o',
		'calibration_m',
		'calibration_c',
		'delta',
		'image',
		'spike_threshold',
		'type',
		'location',
		'b1',
		'b2',
		'b3',
		'b4',
		'b5',
		'h1',
		'h2',
		'h3',
		'h4',
		'h5',
		'w1',
		'w2',
		'w3',
		'w4',
		'w5',
		'alarmlevel',
    ];
	
	public static function getStation($id=0,$fields='bwl_station.*'){
		$user_id = Auth::user()->id; 
		$user_role = Auth::user()->user_role; 
		if($user_role==1){
			$station = Station::selectRaw($fields)->where('is_active',0);
			if($id>0){
				$station = $station->where('id',$id);
			}
			$station = $station->orderBy('order_by','ASC')->get();
		}else{			

			$station=Station::selectRaw($fields)->join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
					->where('bwl_user_station.uid',$user_id)
					->where('bwl_station.is_active',0);					
			if($id>0){
				$station = $station->where('id',$id);
			}
			$station = $station->orderBy('order_by','ASC')->get();
		}
		return $station;
	}
	public static function getStationID($id){
		$station = Station::find($id);
		$station_id = 0;
		if($station){
			$station_id = $station->station_id; 
		}
		return $station_id;
	}

	public static function getMinmax($stationID){


		$previousDaytime = date('Y/m/01 00:00:00',strtotime("-1 month"));
		$daterange = ($previousDaytime.' - '.date('Y/m/t 23:59:59',strtotime("-1 month")));

		
		// $previousDaytime = date('Y/m/01 00:00:00');
		// $daterange = ($previousDaytime.' - '.date('Y/m/t 23:59:59'));

		$daterange = str_replace('-','to',$daterange);
		$daterange = str_replace('/','-',$daterange);
		$daterangeArray = explode('to',$daterange);
			
		$starttime = trim($daterangeArray[0]);
		$endtime = trim($daterangeArray[1]); 
		$starttime = date('Y-m-d H:i:s',strtotime($starttime));
		$endtime = date('Y-m-d H:i:s',strtotime($endtime));


		$max = Rawdata::selectRaw('id,(waterlever_mrl) AS max,datetime as max_datetime')
									->where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy("waterlever_mrl","DESC")
							->first(); 
			
		$min = Rawdata::selectRaw('id,waterlever_mrl AS min, datetime as min_datetime')
								->where('station_id',$stationID)
								->whereRaw("datetime >='$starttime'")
								->whereRaw("datetime <='$endtime'")
								->orderBy("waterlever_mrl","ASC")
								->first(); 

		$max = (isset($max['max'])) ? ($max['max']) : 0;
		$min = (isset($max['min'])) ? ($max['min']) : 0;



		return ['min'=>$min,'max'=>$max];

	}

	public static function flowType($type=0){
		if($type==0){
			$text = 'Flow';
		}else if($type==1){
			$text = 'Reservoir Level';
		}else{
			$text = 'Rain Gauge';			
		}
		return $text;
	}

}

