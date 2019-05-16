<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\Project;
use App\Models\Rawdata;
use App\Models\StationGrouping;
use Auth;
use Redirect;
use Hash;
use App;
use Session;
use File;
use DB;

class StationController extends Controller
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
  
	
	public function index(){
		$checkAuth=Helper::checkAuthFunction(2,'view');
		if($checkAuth){
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			if($user_role==1){
				$station = Station::get();
			}else{				
				$station=Station::join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
						->where('bwl_user_station.uid',$user_id)>get();
			}
			return view('admin.station.index')->with(array('station'=>$station));
		}else{
			App::abort(404);
		}
	}
	public function add(Request $request){
		
		$checkAuth=Helper::checkAuthFunction(2,'add');
		if($checkAuth){				
			if($request->isMethod('post')){		

				$allowed    = array('jpg','JPG','jpeg','JPEG','png','PNG'); 
				$error = 0;
				$image = $request->file('image');
				if($image!='') {  
					$extension  = $image->getClientOriginalExtension();
					if(!in_array($extension,$allowed)) {   
						$error = 1;
					}
					$imagedata = getimagesize($image);
					$width = $imagedata[0];
					$height = $imagedata[1];
					if(($width<1000&&$width>1500) || ($height<450&&$height>700)){
						// $error = 1;
					}
					$imagesize = filesize($image);
					if($imagesize>5242880){
						$error = 1;
					}					
					if($error){
						return redirect()->back()->with('error_msg',"Complaint Check Points Image File size of maximum 5MB is allowed. File type of .jpg, .jpeg, .png are allowed.");
					}
				}	
				
				$data=$request->all();
				
				if($image!='' && !$error) {   
					$destination = 'public/stations/';
					$newname = str_random(10);
					$ext = $image->getClientOriginalExtension();
					$filename = $newname.'-original.'.$ext;
					$newFilename = $newname.'.'.$ext;

					if($image->move($destination, $newFilename)){
						// copy($destination . $filename, $destination . $newFilename);						
						// $solutions->image=$newFilename;
					}
					$data['image'] = $newFilename;					
				}
				if(Station::create($data)){
					$data['location'] = $data['station_name'];
					$data['cope_level'] = $data['copelevel'];
					$data['invert_level'] = $data['invertlevel'];
					$data['mode'] = (isset($data['maintenance']) && ($data['maintenance'])!=0 )?('maintenance'):('active');
					Helper::awsShadow($data);
				
					Session::flash('success_msg','Station Successfully Added');
					return redirect()->back();
				}else{
					Session::flash('error_msg',"Station can't Add");
					return redirect()->back();
				}
			}else{	
				$projects = Project::get();
				return view('admin.station.add')->with(array('projects'=>$projects));
			}
		}else{
			App::abort(404);
		}
	}
	public function edit(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'edit');
		if($checkAuth){						
			$station=Station::find($id);
			if($request->isMethod('post')){
				
				$allowed    = array('jpg','JPG','jpeg','JPEG','png','PNG'); 
				$error = 0;
				$image = $request->file('image');
				if($image!='') {  
					$extension  = $image->getClientOriginalExtension();
					if(!in_array($extension,$allowed)) {   
						$error = 1;
					}
					$imagedata = getimagesize($image);
					$width = $imagedata[0];
					$height = $imagedata[1];
					if(($width<1000&&$width>1500) || ($height<450&&$height>700)){
						// $error = 1;
					}
					$imagesize = filesize($image);
					if($imagesize>5242880){
						$error = 1;
					}					
					if($error){
						return redirect()->back()->with('error_msg',"Complaint Check Points Image File size of maximum 5MB is allowed. File type of .jpg, .jpeg, .png are allowed.");
					}
				}	
				
				$data=$request->all();
				
				$awsShadowdata = array();
				
				$awsShadowdata['station_id'] = $request->station_id;
				$awsShadowdata['pub_id'] = $request->pub_id;
				if($station->station_name!=$request->station_name) { $awsShadowdata['location'] = $request->station_name; }
				if($station->copelevel!=$request->copelevel) { $awsShadowdata['cope_level'] = $request->copelevel; }
				if($station->invertlevel!=$request->invertlevel) { $awsShadowdata['invert_level'] = $request->invertlevel; }
				// if($station->calibration_c!=$request->calibration_c) { $awsShadowdata['calibration_c'] = $request->calibration_c; }
				// if($station->calibration_m!=$request->calibration_m) { $awsShadowdata['calibration_m'] = $request->calibration_m; }

				// Helper::p($request->all(),false);
				// Helper::p("$station->offset_o!=$request->offset_o",false);

				if($station->offset_o!=$request->offset_o) { $awsShadowdata['offset_o'] = $request->offset_o; }
				// if($station->delta!=$request->delta) { $awsShadowdata['delta'] = $request->delta; }
				// if($station->location!=$request->location) { $awsShadowdata['location'] = $request->location; }
				// if($station->spike_threshold!=$request->spike_threshold) { $awsShadowdata['spike_threshold'] = $request->spike_threshold; }
				if($station->maintenance != $request->maintenance) {
					$awsShadowdata['mode'] = (isset($request->maintenance) && ($request->maintenance)!=0 )?('maintenance'):('active');
				}

				if($station->b1!=$request->b1) { $awsShadowdata['b1'] = $request->b1; }
				if($station->b2!=$request->b2) { $awsShadowdata['b2'] = $request->b2; }
				if($station->b3!=$request->b3) { $awsShadowdata['b3'] = $request->b3; }
				if($station->b4!=$request->b4) { $awsShadowdata['b4'] = $request->b4; }
				if($station->b5!=$request->b5) { $awsShadowdata['b5'] = $request->b5; }
				if($station->h1!=$request->h1) { $awsShadowdata['h1'] = $request->h1; }
				if($station->h2!=$request->h2) { $awsShadowdata['h2'] = $request->h2; }
				if($station->h3!=$request->h3) { $awsShadowdata['h3'] = $request->h3; }
				if($station->h4!=$request->h4) { $awsShadowdata['h4'] = $request->h4; }
				if($station->h5!=$request->h5) { $awsShadowdata['h5'] = $request->h5; }
				if($station->w1!=$request->w1) { $awsShadowdata['w1'] = $request->w1; }
				if($station->w2!=$request->w2) { $awsShadowdata['w2'] = $request->w2; }
				if($station->w3!=$request->w3) { $awsShadowdata['w3'] = $request->w3; }
				if($station->w4!=$request->w4) { $awsShadowdata['w4'] = $request->w4; }
				if($station->w5!=$request->w5) { $awsShadowdata['w5'] = $request->w5; }

				// Helper::p($awsShadowdata);
			
				if($image!='' && !$error) {   
					$destination = 'public/stations/';
					if($station->image){
						$path=$destination.($station->image);
						File::delete($path);
					}
					$newname = str_random(10);
					$ext = $image->getClientOriginalExtension();
					$filename = $newname.'-original.'.$ext;
					$newFilename = $newname.'.'.$ext;

					if($image->move($destination, $newFilename)){
						// copy($destination . $filename, $destination . $newFilename);	
						$data['image'] = $newFilename;
					}
										
				}
				if($station->fill($data)->save()){
					
					Helper::awsShadow($awsShadowdata);


					Session::flash('success_msg', 'Station Successfully Updated'); 
					return redirect()->back();
				}else{					
					Session::flash('error_msg', "Station can't Update!"); 
					return redirect()->back();	
				}
			}else{			
				$projects = Project::get();
				return view('admin.station.edit')->with(array('station'=>$station,'projects'=>$projects));
			}
		}else{
			App::abort(404);
		}
	}
	public function deleteRow(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'delete');
		if($checkAuth){						
			$station=Station::find($id);
			if($station->delete()){
				Session::flash('success_msg','Station Successfully Deleted');
				return redirect()->back();
			}else{
				Session::flash('error_msg', "Station can't Delete");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	public function status(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'edit');
		if($checkAuth){						
			$station=Station::find($id);
			$station->is_active=($station->is_active==0)?1:0;
			if($station->save()){
				Session::flash('success_msg','Station Successfully Status Changed');
				return redirect()->back();
			}else{
				Session::flash('error_msg', "Station can't Status Change");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	
	public function getStation($id){
		$station = Station::getStation($id);
		$data = array();
		$percentage50 = 0;
		$percentage75 = 0;
		$percentage90 = 0;
		$percentage = 0;
		$maintenance = 0;
		$total = 0;
		foreach($station as $key=>$val){
			
			$stationID = Station::getStationID($val->id);
			
			$rawdata = Rawdata::where('station_id',$stationID)
							->orderBy('datetime','DESC')
							->first(); 
							
			$datetime = isset($rawdata->datetime)?(date('d-m-Y H:i',strtotime($rawdata->datetime))):'';
			$waterlevel_meter = isset($rawdata->waterlevel_meter)?($rawdata->waterlevel_meter):0;
			$waterlever_mrl = isset($rawdata->waterlever_mrl)?($rawdata->waterlever_mrl):0;
			$maintenance_status = isset($rawdata->maintenance_status)?($rawdata->maintenance_status):0;
			
			$row_array = array();
			$row_array['id'] = $val->id;
			$row_array['stationID'] = $val->station_id;
			$row_array['stationname'] = $val->station_name;
			$row_array['lat'] = $val->station_latitude;
			$row_array['lon'] = $val->station_longitude;
			$row_array['copelevel'] = $val->copelevel;
			$row_array['invertlevel'] = $val->invertlevel;
			$row_array['datetime'] = $datetime;
			$row_array['waterlevel_meter'] = $waterlevel_meter;
			$row_array['waterlever_mrl'] = $waterlever_mrl;
			$row_array['image'] = '';
			
			$totalPercentage = ($val->copelevel)-($val->invertlevel);
			
			if($rawdata){
				
				$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
				$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
				$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;	
				$cal_percentage = $totalPercentage+$val->invertlevel;			
				
				$row_array['waterlever_mrl'] = $waterlever_mrl;
				$row_array['totalPercentage'] = $cal_percentage;
				$row_array['cal_percentage50'] = $cal_percentage50;
				$row_array['cal_percentage75'] = $cal_percentage75;
				$row_array['cal_percentage90'] = $cal_percentage90;
				
				if($maintenance_status==1 ||  $val->maintenance==1){
					$maintenance +=1;
					$row_array['image'] = 'black';
				}else if($waterlever_mrl>$cal_percentage90){
					$percentage90 +=1;
					$row_array['image'] = 'red';
				}else if($waterlever_mrl>$cal_percentage75){
					$percentage75 +=1;
					$row_array['image'] = 'yellow';
				}else if($waterlever_mrl<=$cal_percentage75){
					$percentage50 +=1;
					$row_array['image'] = 'green';
				}
				
				if($maintenance_status==1 ||  $val->maintenance==1){
					$row_array['status'] =  'Maintenance';
				}else if($waterlever_mrl>$cal_percentage){
					$row_array['status'] =  'Above 100%';
				}else if($waterlever_mrl>$cal_percentage90){
					$row_array['status'] =  '91 - 100%';
				}else if($waterlever_mrl>$cal_percentage75){
					$row_array['status'] =  '76 - 90%';
				}else if($waterlever_mrl>=$cal_percentage50){
					$row_array['status'] =  '50 - 75%';
				}else{
					$row_array['status'] =  'Below 50%';
				}
				
				$total++;
			}
				
			
			$data[] = $row_array;
		}

		$data['percentage90'] = $percentage90;		
		$data['percentage75'] = $percentage75;		
		$data['percentage50'] = $percentage50;		
		$data['maintenance'] = $maintenance;		
		$data['total'] = $total;		
		
		return $data;
	}
	
	public function getStationAll($id){
		$station = Station::getStation();
		$data = array();
		$percentage50 = 0;
		$percentage75 = 0;
		$percentage90 = 0;
		$percentage = 0;
		$maintenance = 0;
		$total = 0;
		foreach($station as $key=>$val){
			
			$stationID = Station::getStationID($val->id);
			
			$rawdata = Rawdata::where('station_id',$stationID)
							->orderBy('datetime','DESC')
							->first(); 
							
			$lasthalfhourdata = Rawdata::where('station_id',$stationID)
									->whereRaw('datetime > (NOW() - INTERVAL 30 MINUTE) ')
									->first(); 
							
			$datetime = isset($rawdata->datetime)?(date('d-m-Y H:i',strtotime($rawdata->datetime))):'';
			$waterlevel_meter = isset($rawdata->waterlevel_meter)?($rawdata->waterlevel_meter):0;
			$waterlever_mrl = isset($rawdata->waterlever_mrl)?($rawdata->waterlever_mrl):0;
			$maintenance_status = isset($rawdata->maintenance_status)?($rawdata->maintenance_status):0;
			
			$row_array = array();
			$row_array['id'] = $val->id;
			$row_array['stationID'] = $val->station_id;
			$row_array['stationname'] = $val->station_name;
			$row_array['pub_id'] = $val->pub_id;
			$row_array['type'] = $val->type;
			$row_array['lat'] = $val->station_latitude;
			$row_array['lon'] = $val->station_longitude;
			$row_array['copelevel'] = $val->copelevel;
			$row_array['invertlevel'] = $val->invertlevel;
			$row_array['datetime'] = $datetime;
			$row_array['waterlevel_meter'] = $waterlevel_meter;
			$row_array['waterlever_mrl'] = $waterlever_mrl;
			$row_array['image'] = '';
			
			$totalPercentage = ($val->copelevel)-($val->invertlevel);
			
			if($rawdata){
				
				$cal_percentage50 = Helper::percentage(50,$totalPercentage)+$val->invertlevel;
				$cal_percentage75 = Helper::percentage(75,$totalPercentage)+$val->invertlevel;
				$cal_percentage90 = Helper::percentage(90,$totalPercentage)+$val->invertlevel;	
				$cal_percentage = $totalPercentage+$val->invertlevel;			
				
				$row_array['waterlever_mrl'] = $waterlever_mrl;
				$row_array['totalPercentage'] = $cal_percentage;
				$row_array['cal_percentage50'] = $cal_percentage50;
				$row_array['cal_percentage75'] = $cal_percentage75;
				$row_array['cal_percentage90'] = $cal_percentage90;
				
				if($maintenance_status==1 ||  $val->maintenance==1 || !$lasthalfhourdata){
					$maintenance +=1;
					$row_array['image'] = 'black';
				}else if($waterlever_mrl>$cal_percentage90){
					$percentage90 +=1;
					$row_array['image'] = 'red';
				}else if($waterlever_mrl>$cal_percentage75){
					$percentage75 +=1;
					$row_array['image'] = 'yellow';
				}else if($waterlever_mrl<=$cal_percentage75){
					$percentage50 +=1;
					$row_array['image'] = 'green';
				}
				
				if($maintenance_status==1 ||  $val->maintenance==1 || !$lasthalfhourdata){
					$row_array['status'] =  'Maintenance';
				}else if($waterlever_mrl>$cal_percentage){
					$row_array['status'] =  'Above 100%';
				}else if($waterlever_mrl>$cal_percentage90){
					$row_array['status'] =  '91 - 100%';
				}else if($waterlever_mrl>$cal_percentage75){
					$row_array['status'] =  '76 - 90%';
				}else if($waterlever_mrl>=$cal_percentage50){
					$row_array['status'] =  '50 - 75%';
				}else{
					$row_array['status'] =  'Below 50%';
				}
				$total++;
			}
				
			
			$data['alldata'][] = $row_array;
			
			if($val->id==$id){				
				$data['lat'] = $val->station_latitude;
				$data['lon'] = $val->station_longitude;
			}
		}

		$data['percentage90'] = $percentage90;		
		$data['percentage75'] = $percentage75;		
		$data['percentage50'] = $percentage50;		
		$data['maintenance'] = $maintenance;		
		$data['total'] = $total;		
		
		return $data;
	}
	
	public function getStationById($station_id){
		$station = Station::where('station_id',$station_id)->first();
		$data = array();
		if($station){
			
			$rawdata = Rawdata::where('station_id',$station_id)
							->orderBy('datetime','DESC')
							->first(); 
			$datetime = isset($rawdata->datetime)?($rawdata->datetime):'';
			$waterlevel_meter = isset($rawdata->waterlevel_meter)?($rawdata->waterlevel_meter):0;
			$waterlever_mrl = isset($rawdata->waterlever_mrl)?($rawdata->waterlever_mrl):0;
			
			$row_array = array();
			$row_array['id'] = $station->id;
			$row_array['stationID'] = $station->station_id;
			$row_array['stationname'] = $station->station_name;
			$row_array['lat'] = $station->station_latitude;
			$row_array['lon'] = $station->station_longitude;
			$row_array['copelevel'] = $station->copelevel;
			$row_array['invertlevel'] = $station->invertlevel;
			$row_array['datetime'] = $station->datetime;
			$row_array['waterlevel_meter'] = $station->waterlevel_meter;
			$row_array['waterlever_mrl'] = $station->waterlever_mrl;
			if($station->maintenance==1){
				$row_array['image'] = 'green';
			}else{
				$row_array['image'] = 'black';
			}			
			$row_array['image'] = $image;
			$data[] = $row_array;
		}
		return $station;
	}
	
	public function getChartrawdata(Request $request){
		
		$station_id = ($request->station_id);
		$percentage50 = ($request->percentage50);
		$totalPercentage = ($request->totalPercentage);
		$daterange = (isset($request->daterange) && ($request->daterange))?($request->daterange):(date('Y/m/d 00:00:00').' - '.date('Y/m/d H:i:59'));
		$daterange = str_replace('-','to',$daterange);
		$daterange = str_replace('/','-',$daterange);
		$daterangeArray = explode('to',$daterange);
		
		$starttime = trim($daterangeArray[0]);
		$endtime = trim($daterangeArray[1]); 
		$starttime = date('Y-m-d H:i:s',strtotime($starttime));
		$endtime = date('Y-m-d H:i:s',strtotime($endtime));
		
		$stationID = Station::getStationID($station_id);
		
		$allRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','ASC')
							->get(); 
		$row_array = array(); 
		$row_array2 = array(); 
		$i = 0;
		if(count($allRawdata)>0){
			foreach($allRawdata as $key=>$val){
				$firstmrl = $val->waterlever_mrl;
				$rateof_change = (float)$firstmrl;
				$row_array[] =  array((0 +(strtotime($val->datetime)*1000)) ,$rateof_change);
				if($val->maintenance_status==1){					
					if(isset($row_array2[$i]['from']) && $row_array2[$i]['from']){
						$row_array2[$i]['to'] = (strtotime($val->datetime)*1000);
						$row_array2[$i]['color'] = '#ddd';
						$i++;
						$row_array2[$i]['from'] = (strtotime($val->datetime)*1000);
					}else{
						$row_array2[$i]['from'] = (strtotime($val->datetime)*1000);
					}
				}else{
					$row_array2[$i]['from'] = '';
				}
			}
		}
		return array('data'=>$row_array,'data2'=>$row_array2);
	}
	
	public function getDashboardrawdata(Request $request){
		
		$station_id = ($request->station_id);
		
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
		
		$allRawdata = Rawdata::where('station_id',$stationID)
							->whereRaw("datetime >='$starttime'")
							->whereRaw("datetime <='$endtime'")
							->orderBy('datetime','ASC')
							->get(); 
		$row_array = array(); 
		$firstmrl = 0;
		if(count($allRawdata)>0){
			foreach($allRawdata as $key=>$val){
				$firstmrl = $val->waterlever_mrl;
				$rateof_change = (float)$firstmrl;
				$row_array[] =  array((0 +(strtotime($val->datetime)*1000)),$rateof_change);
			}
		}
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
		$result['max'] = isset($max->max)?(($max->max)):0;
		$result['min'] = isset($min->min)?(($min->min)):0;
		$result['waterlever_mrl'] = $firstmrl;
		$result['time'] = date('Y-m-d H:i');
		$result['data'] = $row_array;
		return $result;
	}
	
	public function stationGrouping(Request $request){
		$checkAuth=Helper::checkAuthFunction(10,'edit');
		if($checkAuth){	
			
			$user_id = Auth::user()->id; 
			if($request->isMethod('post')){		
				$grouping = StationGrouping::where('user_id',$user_id)->get(); 
				foreach($grouping as $key=>$val){
					$group_name = (isset($request->group_name[$val->id]) && $request->group_name[$val->id])?($request->group_name[$val->id]):'';
					$station1 = (isset($request->station1[$val->id]) && $request->station1[$val->id])?($request->station1[$val->id]):0;
					$station2 = (isset($request->station2[$val->id]) && $request->station2[$val->id])?($request->station2[$val->id]):0;
					$station3 = (isset($request->station3[$val->id]) && $request->station3[$val->id])?($request->station3[$val->id]):0;
					$station4 = (isset($request->station4[$val->id]) && $request->station4[$val->id])?($request->station4[$val->id]):0; 
					
					$selection = $request->selection;
					$group = StationGrouping::find($val->id);
					$group->group_name = $group_name;
					$group->station1 = $station1;
					$group->station2 = $station2;
					$group->station3 = $station3;
					$group->station4 = $station4;
					if($val->id==$selection){
						$group->is_active = 0;
					}else{
						$group->is_active = 1;
					}
					$group->save();
				}
				Session::flash("success_msg","Station Grouping Successfully Updated.");
				return redirect()->back();
			}else{			
				$stations = Station::getStation(); 
				$grouping = StationGrouping::where('user_id',$user_id)->get();
				
				if(count($grouping)<20){
					for($i=count($grouping);$i<20;$i++){
						$group = new StationGrouping;
						$group->user_id = $user_id;
						$group->is_active = 1;
						$group->save();
					}					
				}
				
				return view('admin.station.stationGrouping')->with(array('stations'=>$stations,'grouping'=>$grouping));
			}
		}else{
			App::abort(404);
		}
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
			
			foreach($station as $key=>$val){
				$data = array();
				$stationID = $val->station_id;
				
				
				$data['station_id'] = $stationID;
				$data['station_name'] = $val->station_name;
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
					$exlrows[] = array($stationID,$val->station_name,$working_hours,$non_working_hours);
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
