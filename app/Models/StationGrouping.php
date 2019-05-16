<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helper;
use App\Models\Station;

use DB;


class StationGrouping extends Model {

	protected $table = 'station_grouping';
    
	protected $fillable = [
		'user_id',
		'group_name',
		'station1',
		'station2',
		'station3',
		'station4',
		'station1_cl',
		'station2_cl',
		'station3_cl',
		'station4_cl',
		'is_active'
    ];
	
	public static function getDisplaydata($id){
		
		$station = Station::find($id);
		
		$data['criticallevel'] = 0;
		$data['totalPercentage'] = 0;
		$data['percentage50'] = 0;
		$data['percentage75'] = 0;
		$data['percentage90'] = 0;
		$data['waterlever_mrl'] = 0;
		$data['max'] = 0;
		$data['min'] = 0;
		$data['copelevel'] = 0;
		$data['invertlevel'] = 0;
		$data['operationlevel'] = 0;
		$data['station_id'] = 0;
		$data['name'] = '';
		$data['ymax'] = 100;
		$data['stationID'] = '';
		
		if($station){
			
			
			$data['station_id'] = $id;
			$data['copelevel'] = $station->copelevel;
			$data['stationID'] = $station->station_id;
			$data['invertlevel'] = $station->invertlevel;
			$data['operationlevel'] = $station->operationlevel;
			$data['name'] = $station->station_name;
			
			$stationID = $station->station_id;
			
			$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
			$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);

			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
		
			$lastRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->first();
							
			$maxData = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->max('waterlever_mrl');
			$minData = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->min('waterlever_mrl');
			
							
			$data['waterlever_mrl'] = isset($lastRawdata->waterlever_mrl)?($lastRawdata->waterlever_mrl):0;
			$data['max'] = $maxData;
			$data['min'] = $minData;
		
			$data['criticallevel'] = $station->criticallevel;				
			$totalPercentage = ($station->copelevel-$station->invertlevel);
			$data['ymax'] = $station->copelevel+1;
			$data['percentage50'] = Helper::percentage(50,$totalPercentage)+$station->invertlevel;
			$data['percentage75'] = Helper::percentage(75,$totalPercentage)+$station->invertlevel;
			$data['percentage90'] = Helper::percentage(90,$totalPercentage)+$station->invertlevel;
			$data['totalPercentage'] = $totalPercentage+$station->invertlevel;
		}
		
		return (object)$data;
				
	}
}

