<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Station;
use App\Models\StationGrouping;
use App\Models\Rawdata;
use Auth;
use Redirect;
use Hash;
use Excel;
use Response;
use DB;

class PageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  
	public function dashboard(){
		return redirect('map/0');
	}
	public function saveImage(Request $request){
		
		$station_id = isset($request['station_id'])?($request['station_id']):'';
		$station = Station::where('id',$station_id)->where('is_active',0)->first();
		if(!$station){
			return Response::json(array('result'=>false));
		}
		$stationID = Station::getStationID($station_id);
		
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
				
				$daterange = str_replace('-','to',$daterange);
				$daterange = str_replace('/','-',$daterange);
				$daterangeArray = explode('to',$daterange);
			
				$starttime = trim($daterangeArray[0]);
				$endtime = trim($daterangeArray[1]); 
				$starttime = date('Y-m-d H:i:s',strtotime($starttime));
				$endtime = date('Y-m-d H:i:s',strtotime($endtime));
				 // DB::enableQueryLog();
				$allRawdataAsc = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','ASC')
							->get(); 
				// echo '<pre>';print_r(DB::getQueryLog());
				
				$stationID = $stationID.date('_d_M_Y');
				file_put_contents("public/export/".$stationID.".png", base64_decode(explode(",", $request['data'])[1]));
				
				$rows = array();
				$rows['station_id'] = array("Station ID: $station->station_id");
				$rows['station_name'] = array("Station Name: $station->station_name");
				$rows['datetime'] = array("Datetime :".date('d-M-Y H:i:s'));
				$rows['heading'] = array('Datetime','Waterlevel(m)','Water level (mRL)','Rate of Change','Status');
				
				$html  = '<table><tr><th>Station ID</th><th>'.$station->station_id.'</th></tr>';
				$html  .= '<tr><th>Station Name</th><th>'.$station->station_name.'</th></tr>';
				$html  .= '<tr><th>Datetime</th><th>'.date('d-M-Y H:i:s').'</th></tr>';
				$html  .= '<tr><th>Datetime</th><th>Waterlevel(m)</th><th>Water level (mRL)</th><th>Rate of Change</th><th>Status</th></tr>';
				// echo ($allRawdataAsc);exit;
				// echo count($allRawdataAsc);
				$data = array();
				foreach($allRawdataAsc as $key=>$val){
					$statusText = ($val->maintenance_status==1)?('Maintenance'):('Running');
					$secondlastKey = ($key-1);
					if($secondlastKey<0){$secondlastKey=0;}
					$secondmrl = isset($allRawdataAsc[$secondlastKey]->waterlever_mrl)?($allRawdataAsc[$secondlastKey]->waterlever_mrl):0;
					$firstmrl = $val->waterlever_mrl;
					$rateof_change = $secondmrl-$firstmrl;
					// $data[]=array(date('d-M-Y H:i:s',strtotime($val->datetime)),$val->waterlevel_meter,$val->waterlever_mrl,$rateof_change,$statusText);
					$html  .= '<tr><td>'.date('d-M-Y H:i:s',strtotime($val->datetime)).'</td><td>'.$val->waterlevel_meter.'</td><td>'.$val->waterlever_mrl.'</td><td>'.$rateof_change.'</td><td>'.$statusText.'</td></tr>';
				}
				
				$html  .= '</td></tr></table>';
				$html  .= '</html>';
		
		
		
				// echo $html;exit;
				Excel::create($stationID, function($excel) use($stationID,$html) {

					$excel->sheet($stationID, function($sheet) use($stationID,$html){

						$sheet->loadView('admin.export')->with('stationID',$stationID)->with('html',$html);

					});
					$excel->sheet($stationID, function($sheet) use($stationID,$html){

						$sheet->loadView('admin.export2')->with('stationID',$stationID)->with('html',$html);

					});

				})->save('xlsx');;
		
		
	}
	public function map($id){
		$check = Helper::checkAuthFunction(1);
		if($check){
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			if($user_role==1){
				$station = Station::where('is_active',0)->orderBy('station_id','ASC')->get();
			}else{				
				$station=Station::join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
						->where('bwl_user_station.uid',$user_id)
						->where('bwl_station.is_active',0)
						->orderBy('station_id','ASC')
						->get();
			}
			// Helper::p($station);
			return view('admin.map')->with(array('station'=>$station,'selectedId'=>$id));
		}
	}
	public function status(){
		$check = Helper::checkAuthFunction(1);
		if($check){
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			if($user_role==1){
				$station = Station::where('is_active',0)->orderBy('station_id','ASC')->get();
			}else{				
				$station=Station::join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
						->where('bwl_user_station.uid',$user_id)
						->where('bwl_station.is_active',0)
						->orderBy('station_id','ASC')
						->get();
			}
			// Helper::p($station);
			return view('admin.status')->with(array('station'=>$station));
		}
	}
	public function smsList(){
		$check = Helper::checkAuthFunction(15);
		if($check){
			
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			
			$station = Station::selectRaw('bwl_station.station_id,bwl_station.station_name,users.username,users.mobile')
							->join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
							->join('users','users.id','=','bwl_user_station.uid')
							->where('bwl_station.is_active',0)
							->get(); 
							
			$stations = array();
			foreach($station as $key=>$val){
				$stations[$val->station_id]['station_id'] = $val->station_id; 
				$stations[$val->station_id]['station_name'] = $val->station_name;
				$stations[$val->station_id]['username'][] = ($val->username!='')?($val->username):'-';
				$stations[$val->station_id]['mobile'][] = ($val->mobile!='')?($val->mobile):'-';
			}
			// Helper::p($stations);

			return view('admin.smsList')->with(array('stations'=>$stations));
		}
	}
	public function dashboardData(Request $request){
		$check = Helper::checkAuthFunction(7);
		if($check){
			
			$station = Station::getStation();
			
			$total = 0;
			
			$percentage50 = 0;
			$percentage75 = 0;
			$percentage90 = 0;
			$percentage = 0;
			$maintenance = 0;
			
			foreach($station as $key=>$val){
				
				$totalPercentage = ($val->copelevel)-($val->invertlevel);
				
				$stationID = Station::getStationID($val->id);
				
				$lastRow = Rawdata::where('station_id',$stationID)
								->orderBy('datetime','DESC')
								->first(); 
				if($lastRow){				
					
					$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
					$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
					$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;
					$cal_percentage = $totalPercentage+$val->invertlevel;
					
					$actualpercentage = $lastRow->waterlever_mrl;
					
					
					if($lastRow->maintenance_status==1 || $val->maintenance==1){
						$maintenance +=1;
					}else if($actualpercentage>$cal_percentage){
						$percentage +=1;
					}else if($actualpercentage>$cal_percentage90){
						$percentage90 +=1;
					}else if($actualpercentage>$cal_percentage75){
						$percentage75 +=1;
					}else if($actualpercentage<=$cal_percentage75){
						$percentage50 +=1;
					}
					
					$total++;
				}
				
			}
			
			$data[] = $total;
			$data[] = $percentage50;
			$data[] = $percentage75;
			$data[] = $percentage90;
			$data[] = $percentage;
			$data[] = $maintenance;
			
			$datas[] = array('y'=>(int)$total,'color'=>'#046996');
			$datas[] = array('y'=>(int)$percentage50,'color'=>'#36d411');
			$datas[] = array('y'=>(int)$percentage75,'color'=>'#d8ba1e');
			$datas[] = array('y'=>(int)$percentage90,'color'=>'#ff0000');
			$datas[] = array('y'=>(int)$percentage,'color'=>'#ff0000');
			$datas[] = array('y'=>(int)$maintenance,'color'=>'#000000');
			
			return view('admin.dashboardData')->with(array('data'=>$data,'datas'=>$datas));
		}
	}
	
	public function viewStationGroup(Request $request){
		$check = Helper::checkAuthFunction(17);
		if($check){
			
			$user_id = Auth::user()->id; 
			$grouping = StationGrouping::where('user_id',$user_id)->where('is_active',0)->first(); 
			$stations = Station::getStation();
			$s1 = StationGrouping::getDisplaydata($grouping->station1);
			$s2 = StationGrouping::getDisplaydata($grouping->station2);
			$s3 = StationGrouping::getDisplaydata($grouping->station3);
			$s4 = StationGrouping::getDisplaydata($grouping->station4);
			
			$name = $grouping->group_name;
			
			return view('admin.viewStationGroup')->with(array('s1'=>$s1,'s2'=>$s2,'s3'=>$s3,'s4'=>$s4,'name'=>$name,'stations'=>$stations,'grouping'=>$grouping));
		}
	}
	
	public function export(Request $request){			
	
		$station = Station::where('is_active',0)->whereIn('id',[1,2,3,4,5,6,7,8,9,10])->get();
		foreach($station as $val){
			$station_id = $val->id;
			$client = new \GuzzleHttp\Client();
			$res = $client->request('GET', 'http://tamil/120/export-excel/'.$station_id, [
				'auth' => ['admin', 'password']
			]);
			echo '<br>====================<pre>';
			echo '<br>';
			echo 'http://tamil/120/export-excel/'.$station_id;echo '<br>';
			print_r($res->getStatusCode());echo '<br>';
			print_r($res->getHeader('content-type'));echo '<br>';
			print_r($res->getBody());echo '<br>';
			echo '<br>====================</pre>';
		}
	}
	
	public function exportExcel(Request $request,$id){			
		$s1 = StationGrouping::getDisplaydata($id);			
		return view('admin.exportExcel')->with(array('s1'=>$s1));
	}
	
	public function changeCLStationGroup(Request $request,$grouping_id,$field,$value){
		$grouping = StationGrouping::find($grouping_id); 
		$grouping->$field=$value;
		$grouping->save();
	}
	public function changeStationGroup(Request $request,$grouping_id,$field,$value){
		$grouping = StationGrouping::find($grouping_id); 
		$grouping->$field=$value;
		$grouping->save();
		return redirect()->back();
	}
	
	public function summaryData(Request $request){
		$check = Helper::checkAuthFunction(8);
		if($check){
			
			if($request->isMethod('post')){
				$daterange = $request->daterange;				
				$status = $request->status;				
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
				$status = 1;
			}
			$selectedDaterange = $daterange;
			$station = Station::getStation();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stations = array();
			$rows = array();
			// $i = 0;
			foreach($station as $key=>$val){
				
				$stationID = Station::getStationID($val->id);
			
				$lastRow = Rawdata::selectRaw('datetime,waterlever_mrl,waterlevel_meter')
								->where('station_id',$stationID)
								->whereRaw("datetime >='$starttime'")
								->whereRaw("datetime <='$endtime'")
								->orderBy("datetime","DESC")
								->first(); 
								
				$actualpercentage = isset($lastRow->waterlever_mrl)?(($lastRow->waterlever_mrl)):0;
				$waterlevel_meter = isset($lastRow->waterlevel_meter)?(($lastRow->waterlevel_meter)):0;
				$datetime = isset($lastRow->datetime)?(($lastRow->datetime)):0;
				$maintenance_status = isset($lastRow->maintenance_status)?(($lastRow->maintenance_status)):0;
				
				$totalPercentage = ($val->copelevel)-($val->invertlevel);
				if($lastRow){				
					
					$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
					$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
					$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;
					$cal_percentage = $totalPercentage+$val->invertlevel;
										
										
					$rows['id'] = $val->id;
					$rows['station_id'] = $val->station_id;
					$rows['station_name'] = $val->station_name;
					$rows['waterlever_mrl'] = $actualpercentage;
					$rows['waterlevel_meter'] = $waterlevel_meter;
					$rows['datetime'] = $datetime;
					
					$checkMaintenance = 0;
					
					if($maintenance_status==1 ||  $val->maintenance==1){
						$statustext =  'Maintenance';
						$checkMaintenance = 1;
					}else if($actualpercentage>$cal_percentage){
						$statustext =  'Above 100%';
					}else if($actualpercentage>$cal_percentage90){
						$statustext =  '91 - 100%';
					}else if($actualpercentage>$cal_percentage75){
						$statustext =  '76 - 90%';
					}else if($actualpercentage>=$cal_percentage50){
						$statustext =  '50 - 75%';
					}else{
						$statustext =  ' Below 50%';
					}
					$rows['status'] = $statustext;
					
					if(($checkMaintenance) && ($status== 7 || $status==1)){
						$stations[]=$rows; 
					}else if($actualpercentage>$cal_percentage && ($status==1 || $status== 6 || $status==5 || $status== 4 || $status==3 ) && (!$checkMaintenance)){
						$stations[]=$rows; 
					}else if($actualpercentage>$cal_percentage90 && ($status==1 || $status==5 || $status== 4 || $status==3 && (!$checkMaintenance))){
						$stations[]=$rows;
					}else if($actualpercentage>$cal_percentage75 && ($status==1 || $status== 4 || $status==3 && (!$checkMaintenance))){
						$stations[]=$rows;
					}else if($actualpercentage>=$cal_percentage50 && ($status==1 || $status==3) && (!$checkMaintenance)){
						$stations[]=$rows;
					}else if(($actualpercentage<$cal_percentage50)&& ($status==1 || $status== 2) && (!$checkMaintenance)){
						$stations[]=$rows;
					}
					
					
					
					
					
					// $i++;	
				}		
			}
			
			return view('admin.summaryData')->with(array('stations'=>$stations,'daterange'=>$selectedDaterange,'status'=>$status));
		}
	}
	
	public function display(Request $request,$id){
		
		$check = Helper::checkAuthFunction(1);
		if($check){
			
			$dateranges = (isset($request->onchagnedaterange)&&$request->onchagnedaterange)?($request->onchagnedaterange):'';
			if((isset($request->daterange) && ($request->daterange))){
				$daterange = ($request->daterange);
			}else if($dateranges){
				$daterange = $dateranges;
			}else{				
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			
			$station_id = (isset($request->station_id) && ($request->station_id))?($request->station_id):$id;
			if($request->isMethod('post') && isset($request->downloadCSV)){
				
				$selectedDaterange = $daterange;
				$stations = Station::getStation();
				$station = Station::where('id',$id)->where('is_active',0)->first();
				
				$daterange = str_replace('-','to',$daterange);
				$daterange = str_replace('/','-',$daterange);
				$daterangeArray = explode('to',$daterange);
			
				$starttime = trim($daterangeArray[0]);
				$endtime = trim($daterangeArray[1]); 
				$starttime = date('Y-m-d H:i:s',strtotime($starttime));
				$endtime = date('Y-m-d H:i:s',strtotime($endtime));
				$stationID = Station::getStationID($id);
				
				$allRawdataAsc = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','ASC')
							->get(); 
				
				$rows = array();
				$rows[] = array("Station ID",$station->station_id); 
				$rows[] = array("Station Name",$station->station_name);
				$rows[] = array();
				$rows[] = array("Critical level","$station->criticallevel", "mRL");
				$rows[] = array("Cope/Softfit level", "$station->copelevel", "mRL");
				$rows[] = array("Sensor level", "$station->operationlevel", "mRL");
				$rows[] = array("Invert level", "$station->invertlevel", "mRL");
				$rows[] = array();
				// $rows[] = array("Datetime :".date('d-M-Y H:i:s'));
				$rows[] = array('Datetime','Water depth(m)','Water level (mRL)','Rate of Change(m/min)','Status');
				foreach($allRawdataAsc as $key=>$val){
					$statusText = ($val->maintenance_status==1)?('Maintenance'):('Normal');
					$secondlastKey = ($key-1);
					if($secondlastKey<0){$secondlastKey=0;}
					$secondmrl = isset($allRawdataAsc[$secondlastKey]->waterlever_mrl)?($allRawdataAsc[$secondlastKey]->waterlever_mrl):0;
					$firstmrl = $val->waterlever_mrl;
					// $rateof_change = $secondmrl-$firstmrl;
					$seconddatetime = isset($allRawdataAsc[$secondlastKey]->datetime)?($allRawdataAsc[$secondlastKey]->datetime):'';
					$firstmrl = $val->waterlever_mrl;
					$firstdatetime = $val->datetime;
					$rateof_change = $firstmrl-$secondmrl;
					$min = Helper::getMinutesFromDates($seconddatetime,$firstdatetime);
					if($min>0){
						$rateof_change = $rateof_change / $min;
					}
					$rows[]=array(date('Y-m-d H:i',strtotime($val->datetime)),$val->waterlevel_meter,$val->waterlever_mrl,$rateof_change,$statusText);
				}
				if($rows){
					Helper::downloadCSV($rows,$station->station_id);
					exit;
				}
			}
			// Helper::p($daterange,false);
			// Helper::p($station_id);
			return view('admin.display')->with(array('daterange'=>$daterange,'station_id'=>$station_id));
			
		}
	}
	public function displayContent(Request $request,$id){
		
		$check = Helper::checkAuthFunction(1);
		if($check){
			
			if(isset($request->daterange) && ($request->daterange)){
				$daterange = $request->daterange;				
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			
			$selectedDaterange = $daterange;
			$stations = Station::getStation();
			$station = Station::where('id',$id)->where('is_active',0)->first();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stationID = Station::getStationID($id);
			
			$allRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->get(); 
			$allRawdataAsc = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','ASC')
							->get(); 
			$lastRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->first(); 
			$secondlastRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->skip(1)->take(1)
							->first(); 
							
			$rateof_change=0;
			if($lastRawdata && $secondlastRawdata){
				$rateof_change = ($lastRawdata->waterlever_mrl) - ($secondlastRawdata->waterlever_mrl) ;				
				$min = Helper::getMinutesFromDates($secondlastRawdata->datetime,$lastRawdata->datetime);
				if($min>0){
					$rateof_change = $rateof_change / $min;
				}
			}
			if($request->isMethod('post') && isset($request->downloadCSV)){
				$rows = array();
				$rows[] = array("Station ID",$station->station_id); 
				$rows[] = array("Station Name",$station->station_name);
				$rows[] = array();
				$rows[] = array("Critical level","$station->criticallevel", "mRL");
				$rows[] = array("Cope/Softfit level", "$station->copelevel", "mRL");
				$rows[] = array("Sensor level", "$station->operationlevel", "mRL");
				$rows[] = array("Invert level", "$station->invertlevel", "mRL");
				$rows[] = array();
				// $rows[] = array("Datetime :".date('d-M-Y H:i:s'));
				$rows[] = array('Datetime','Water depth(m)','Water level (mRL)','Rate of Change(m/min)','Status');
				foreach($allRawdataAsc as $key=>$val){
					$statusText = ($val->maintenance_status==1)?('Maintenance'):('Normal');
					$secondlastKey = ($key-1);
					if($secondlastKey<0){$secondlastKey=0;}
					$secondmrl = isset($allRawdataAsc[$secondlastKey]->waterlever_mrl)?($allRawdataAsc[$secondlastKey]->waterlever_mrl):0;
					$seconddatetime = isset($allRawdataAsc[$secondlastKey]->datetime)?($allRawdataAsc[$secondlastKey]->datetime):'';
					$firstmrl = $val->waterlever_mrl;
					$firstdatetime = $val->datetime;
					$rateof_change = $firstmrl-$secondmrl;
					$min = Helper::getMinutesFromDates($seconddatetime,$firstdatetime);
					if($min>0){
						$rateof_change = $rateof_change / $min;
					}
					$rows[]=array(date('Y-m-d H:i',strtotime($val->datetime)),$val->waterlevel_meter,$val->waterlever_mrl,$rateof_change,$statusText);
				}
				if($rows){
					Helper::downloadCSV($rows);
					exit;
				}
			}
			
			
			$totalPercentage = ($station->copelevel-$station->invertlevel);
			$percentage50 = Helper::percentage(50,$totalPercentage)+$station->invertlevel;
			$percentage75 = Helper::percentage(75,$totalPercentage)+$station->invertlevel;
			$percentage90 = Helper::percentage(90,$totalPercentage)+$station->invertlevel;
			$totalPercentage = $totalPercentage + $station->invertlevel;
			$ymax	= $station->copelevel+1;
				
			return view('admin.displayContent')->with(array('stations'=>$stations,'station'=>$station,'ymax'=>$ymax,'allRawdata'=>$allRawdata,'lastRawdata'=>(object)$lastRawdata,'rateof_change'=>$rateof_change,'totalPercentage'=>$totalPercentage,'percentage50'=>$percentage50,'percentage75'=>$percentage75,'percentage90'=>$percentage90,'daterange'=>$selectedDaterange));
		}
	}
	
	public function individualChart(Request $request,$id){
		$check = Helper::checkAuthFunction(9);
		if($check){
			
			if($request->isMethod('post')){
				$daterange = $request->daterange;				
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			$selectedDaterange = $daterange;
			$stations = Station::getStation();
			if($id==0){
				$id = isset($stations[0]->id)?($stations[0]->id):0;
			}
			$station = Station::where('id',$id)->where('is_active',0)->first();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stationID = Station::getStationID($id);
			
			$allRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->get(); 
			$lastRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->first(); 
			$secondlastRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','DESC')
							->skip(1)->take(1)
							->first(); 
							
			$rateof_change=0;
			if($lastRawdata && $secondlastRawdata){
				$rateof_change = ($lastRawdata->waterlever_mrl)-($secondlastRawdata->waterlever_mrl);
			}
			
			$totalPercentage = ($station->copelevel-$station->invertlevel);
			$percentage50 = Helper::percentage(50,$totalPercentage)+$station->invertlevel;
			$percentage75 = Helper::percentage(75,$totalPercentage)+$station->invertlevel;
			$percentage90 = Helper::percentage(90,$totalPercentage)+$station->invertlevel;
			$totalPercentage = $totalPercentage +$station->invertlevel; 
				
			return view('admin.individualChart')->with(array('stations'=>$stations,'station'=>$station,'allRawdata'=>$allRawdata,'lastRawdata'=>(object)$lastRawdata,'rateof_change'=>$rateof_change,'totalPercentage'=>$totalPercentage,'percentage50'=>$percentage50,'percentage75'=>$percentage75,'percentage90'=>$percentage90,'daterange'=>$selectedDaterange));
		}
	}
	
	public function wlMinMax(Request $request){
		$check = Helper::checkAuthFunction(13);
		if($check){
			
			if($request->isMethod('post')){
				$daterange = $request->daterange;				
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			$selectedDaterange = $daterange;
			$station = Station::getStation();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stations = array();
			
			foreach($station as $key=>$val){
				
				$stationID = Station::getStationID($val->id);
			
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
								
				$minid = isset($min->id)?(($min->id)):0;
				$minVal = isset($min->min)?(($min->min)):0;
				$min_datetime = isset($min->min_datetime)?(($min->min_datetime)):'';
				$maxid = isset($max->id)?(($max->id)):0;
				$maxVal = isset($max->max)?(($max->max)):0;
				$max_datetime = isset($max->max_datetime)?(($max->max_datetime)):'';
				if($minVal && $maxVal){
					$stations[$key]['maxid'] = $maxid;
					$stations[$key]['minid'] = $minid;
					$stations[$key]['station_id'] = $val->station_id;
					$stations[$key]['station_name'] = $val->station_name;
					$stations[$key]['min'] = $minVal;
					$stations[$key]['min_datetime'] = $min_datetime;
					$stations[$key]['max'] = $maxVal;
					$stations[$key]['max_datetime'] = $max_datetime;
				}
								
			}
			
			
							
				
			return view('admin.wlMinMax')->with(array('stations'=>$stations,'daterange'=>$selectedDaterange));
		}
	}
	
	public function viewStationGroupContent(Request $request){
		$check = Helper::checkAuthFunction(17);
		if($check){
			$status = (isset($request->status) && ($request->status))?($request->status):1;
			return view('admin.viewStationGroupRaw')->with(array('status'=>$status));
		}		
	}
	public function wlSummary50Content(Request $request){
		$check = Helper::checkAuthFunction(12);
		if($check){
			$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
			$default_daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			$daterange = (isset($request->daterange) && ($request->daterange))?($request->daterange):($default_daterange);
			$status = (isset($request->status) && ($request->status))?($request->status):1;
			return view('admin.wlSummary50Raw')->with(array('daterange'=>$daterange,'status'=>$status));
		}		
	}
	public function wlSummary75Content(Request $request){
		$check = Helper::checkAuthFunction(11);
		if($check){			
			$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
			$default_daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			$daterange = (isset($request->daterange) && ($request->daterange))?($request->daterange):($default_daterange);
			$status = (isset($request->status) && ($request->status))?($request->status):1;
			return view('admin.wlSummary75Raw')->with(array('daterange'=>$daterange,'status'=>$status));
		}		
	}
	
	public function wlSummary50(Request $request){
		$check = Helper::checkAuthFunction(12);
		if($check){
			
			$status = (isset($request->status) && ($request->status))?($request->status):1;
			
			if (isset($request->daterange) && ($request->daterange)){
				$daterange = $request->daterange;	
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			$selectedDaterange = $daterange;
			$station = Station::getStation();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stations = array();
			$resultStations = array();
			$i = 0;
			
			foreach($station as $key=>$val){
				
				$row = array();
				
				$stationID = Station::getStationID($val->id);
			
				$lastRow = Rawdata::selectRaw('datetime,waterlever_mrl')
								->where('station_id',$stationID)
								->whereRaw("datetime >='$starttime'")
								->whereRaw("datetime <='$endtime'")
								->orderBy("datetime","DESC")
								->first(); 
								
				$actualpercentage = isset($lastRow->waterlever_mrl)?(($lastRow->waterlever_mrl)):0;
				$datetime = isset($lastRow->datetime)?(($lastRow->datetime)):0;
				$maintenance_status = isset($lastRow->maintenance_status)?(($lastRow->maintenance_status)):0;
				
				$totalPercentage = ($val->copelevel)-($val->invertlevel);
				if($lastRow && $val->maintenance!=1 && $maintenance_status!=1){				
					
					$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
					$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
					$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;
					$cal_percentage = $totalPercentage+$val->invertlevel;
										
					if($actualpercentage>=$cal_percentage50){
					
						$stations[$i]['id'] = $val->id;
						$stations[$i]['station_id'] = $val->station_id;
						$stations[$i]['station_name'] = $val->station_name;
						$stations[$i]['datetime'] = $datetime;
						
						if($actualpercentage>$cal_percentage){
							$status_text =  'Above 100%';
						}else if($actualpercentage>$cal_percentage90){
							$status_text =  '91 - 100%';
						}else if($actualpercentage>$cal_percentage75){
							$status_text =  '76 - 90%';
						}else if($actualpercentage>=$cal_percentage50){
							$status_text =  '50 - 75%';
						}
					
						$stations[$i]['status'] = $status_text;	
						
						if($actualpercentage>$cal_percentage && ($status==1 || $status== 6 || $status==5 || $status== 4 || $status==3 ) ){
							$resultStations[] = $stations[$i];
						}else if($actualpercentage>$cal_percentage90 && ($status==1 || $status==5 || $status== 4 || $status==3 )){
							$resultStations[] = $stations[$i];
						}else if($actualpercentage>$cal_percentage75 && ($status==1 || $status== 4 || $status==3 )){
							$resultStations[] = $stations[$i];
						}else if($actualpercentage>=$cal_percentage50 && ($status==1 || $status==3)){
							$resultStations[] = $stations[$i];
						}
										
						$i++;
						
					}			
				}
			}
			
			if(count($stations)>4){
				return view('admin.wlSummary50')->with(array('stations'=>$resultStations,'daterange'=>$selectedDaterange,'status'=>$status));
			}else{
				
				$station1 = isset($stations[0]['id'])?($stations[0]['id']):0;
				$station2 = isset($stations[1]['id'])?($stations[1]['id']):0;
				$station3 = isset($stations[2]['id'])?($stations[2]['id']):0;
				$station4 = isset($stations[3]['id'])?($stations[3]['id']):0;
				
				$totalCount=0;
				if($station1>0){ $totalCount++; }if($station2>0){ $totalCount++; }if($station3>0){ $totalCount++; }if($station4>0){ $totalCount++; }
				
				$s1 = StationGrouping::getDisplaydata($station1);
				$s2 = StationGrouping::getDisplaydata($station2);
				$s3 = StationGrouping::getDisplaydata($station3);
				$s4 = StationGrouping::getDisplaydata($station4);
				
				$name = 'WL Summary > 50'; //Helper::p($s1);
				
				return view('admin.wlSummary50Graph')->with(array('s1'=>$s1,'s2'=>$s2,'s3'=>$s3,'s4'=>$s4,'name'=>$name,'totalCount'=>$totalCount));
			}
			
			
		}
	}
	
	public function wlSummary75(Request $request){
		$check = Helper::checkAuthFunction(11);
		if($check){
			
			$status = (isset($request->status) && ($request->status))?($request->status):1;
			
			if (isset($request->daterange) && ($request->daterange)){
				$daterange = $request->daterange;	
			}else{
				$previousDaytime = date('Y/m/d H:i:s',strtotime('-1 day'));
				$daterange = ($previousDaytime.' - '.date('Y/m/d H:i:59'));
			}
			$selectedDaterange = $daterange;
			$station = Station::getStation();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$stations = array();
			$resultStations = array();
			$i = 0;
			foreach($station as $key=>$val){
				
				$stationID = Station::getStationID($val->id);
			
				$lastRow = Rawdata::selectRaw('datetime,waterlever_mrl')
								->where('station_id',$stationID)
								->whereRaw("datetime >='$starttime'")
								->whereRaw("datetime <='$endtime'")
								->orderBy("datetime","DESC")
								->first(); 
								
				$actualpercentage = isset($lastRow->waterlever_mrl)?(($lastRow->waterlever_mrl)):0;
				$datetime = isset($lastRow->datetime)?(($lastRow->datetime)):0;
				$maintenance_status = isset($lastRow->maintenance_status)?(($lastRow->maintenance_status)):0;
				
				$totalPercentage = ($val->copelevel)-($val->invertlevel);
				if($lastRow && $val->maintenance!=1 && $maintenance_status!=1){				
					
					$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
					$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
					$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;
					$cal_percentage = $totalPercentage+$val->invertlevel;
										
					if($actualpercentage>=$cal_percentage75){					
						$stations[$i]['id'] = $val->id;
						$stations[$i]['station_id'] = $val->station_id;
						$stations[$i]['station_name'] = $val->station_name;
						$stations[$i]['datetime'] = $datetime;
						
						if($actualpercentage>$cal_percentage){
							$status_text =  'Above 100%';
						}else if($actualpercentage>$cal_percentage90){
							$status_text =  '91 - 100%';
						}else{
							$status_text =  '76 - 90%';
						}
						
						
						$stations[$i]['status'] = $status_text;
						
						if($actualpercentage>$cal_percentage && ($status==1 || $status== 6 || $status==5 || $status== 4 || $status==3 ) ){
							$resultStations[] = $stations[$i];
						}else if($actualpercentage>$cal_percentage90 && ($status==1 || $status==5 || $status== 4 || $status==3 )){
							$resultStations[] = $stations[$i];
						}else if($actualpercentage>$cal_percentage75 && ($status==1 || $status== 4 || $status==3 )){
							$resultStations[] = $stations[$i];
						}
						
						$i++;	
					}
				}		
			}
			
			if(count($stations)>4){
				return view('admin.wlSummary75')->with(array('stations'=>$resultStations,'daterange'=>$selectedDaterange,'status'=>$status));
			}else{
				
				$station1 = isset($stations[0]['id'])?($stations[0]['id']):0;
				$station2 = isset($stations[1]['id'])?($stations[1]['id']):0;
				$station3 = isset($stations[2]['id'])?($stations[2]['id']):0;
				$station4 = isset($stations[3]['id'])?($stations[3]['id']):0;
				
				$totalCount=0;
				if($station1>0){ $totalCount++; }if($station2>0){ $totalCount++; }if($station3>0){ $totalCount++; }if($station4>0){ $totalCount++; }
				
				$s1 = StationGrouping::getDisplaydata($station1);
				$s2 = StationGrouping::getDisplaydata($station2);
				$s3 = StationGrouping::getDisplaydata($station3);
				$s4 = StationGrouping::getDisplaydata($station4);
				
				$name = 'WL Summary > 75'; // Helper::p($stations);
				
				return view('admin.wlSummary75Graph')->with(array('s1'=>$s1,'s2'=>$s2,'s3'=>$s3,'s4'=>$s4,'name'=>$name,'totalCount'=>$totalCount));
			}
		}
	}
	
	public function profile(Request $request){
		
		if($request->isMethod('post')){
			
			$newPassword=$request->password;			
			$newPwd = Hash::make($newPassword);
			
			$user=Users::find(Auth::user()->id);
            $user->password=$newPwd;  
            $user->password_text=$newPassword;  
			if($user->save()){
				return redirect()->back()->with('success_msg','Your Profile Successfully Updated');
			}else{
				return redirect()->back()->with('error_msg','Update has failed, Please try again!.');
			}
			
		}else{
			
			$user=Users::find(Auth::user()->id); 
			return view('admin.profile')->with(array('user'=>$user));
		}
	}	
	
	public function emptyView(){		
		// $check = Helper::checkAuthFunction(1);
		// if($check){
			return view('admin.empty');
		// }
	}
	
	public function selfAuditing(Request $request){
		$check = Helper::checkAuthFunction(14);
		if($check){
			
			if (isset($request->daterange) && ($request->daterange)){
				$daterange = $request->daterange;	
			}else{
				$previousDaytime = date('Y/m/01 00:00:00');
				$daterange = ($previousDaytime.' - '.date('Y/m/d 23:59:59'));
			}
			$selectedDaterange = $daterange;
			$station = Station::getStation();
			
			$daterange = str_replace('-','to',$daterange);
			$daterange = str_replace('/','-',$daterange);
			$daterangeArray = explode('to',$daterange);
		
			$starttime = trim($daterangeArray[0]);
			$endtime = trim($daterangeArray[1]); 
			$starttime = date('Y-m-d H:i:s',strtotime($starttime));
			$endtime = date('Y-m-d H:i:s',strtotime($endtime));
			
			$resultStations = array();
			$i = 0;
						
			$exlrows = array();
			$exlrows[] = array('Station ID','Station Name','Working Hours','Non Working Hours');
			
			foreach($station as $skey=>$sval){
				$data = array();
				$stationID = $sval->station_id;
				
				
				$data['station_id'] = $stationID;
				$data['station_name'] = $sval->station_name;
				$working_hours = 0;
				$non_working_hours = 0;
			
				$rows = Rawdata::selectRaw('datetime')
								->where('station_id',$stationID)
								->whereRaw("datetime >='$starttime'")
								->whereRaw("datetime <='$endtime'")
								->orderBy("datetime","ASC")
								->get(); 
				foreach($rows as $key=>$val){			
					if($key>0){
						$previous_key=$key-1;
						$previous_row_time = strtotime($rows[$previous_key]->datetime);
					}else{
						$previous_row_time = strtotime($starttime);
					}
					$current_row_time = strtotime($val->datetime);
					
					$diff_minutes = ($current_row_time-$previous_row_time)/60;
					
					if($diff_minutes>=30){
						$non_working_hours += $diff_minutes;
					}else{
						$working_hours += $diff_minutes;
					}
					
					
					
				}
				
				
				$data['working_hours'] = Helper::convertToHoursMins($working_hours);
				$data['non_working_hours'] = Helper::convertToHoursMins($non_working_hours);								
				$resultStations[] = $data;
				
				if($request->isMethod('post') && isset($request->downloadCSV)){
					$working_hours = Helper::convertToHoursMins($working_hours);
					$non_working_hours = Helper::convertToHoursMins($non_working_hours);
					$exlrows[] = array($stationID,$sval->station_name,$working_hours,$non_working_hours);
				}
								
			}
			if($request->isMethod('post') && isset($request->downloadCSV)){				
				if($exlrows){
					Helper::downloadCSV($exlrows);
					exit;
				}
			}			
			return view('admin.selfAuditing')->with(array('stations'=>$resultStations,'daterange'=>$selectedDaterange));
		} 
	}
	
}
