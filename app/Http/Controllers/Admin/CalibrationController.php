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
use App\Models\Calibration;
use Auth;
use Redirect;
use Hash;
use Excel;
use Response;
use DB;
use Session;

class CalibrationController extends Controller
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
		$checkAuth=Helper::checkAuthFunction(18,'view');
		if($checkAuth){
			$calibration = Calibration::get();
			return view('admin.calibration.index')->with(array('calibration'=>$calibration));
		}else{
			App::abort(404);
		}
	}
	public function add(Request $request,$id,$stid=0){
		
		$checkAuth=Helper::checkAuthFunction(18,'add');
		if($checkAuth){				
			
			if($request->isMethod('post') && isset($request->submit) && $request->submit){		
			
				$calibration = Calibration::find($id);
				if(!$calibration){
					$calibration = new Calibration;
				}				
				if(isset($request->station_id) && $request->station_id){
					$calibration->station_id = $request->station_id;
				}
				if($id>0){
					$calibration->adc_100 = $request->adc;
					$calibration->adc_100_datetime = $request->datetime;
					$value = ($request->adc-$calibration->adc_50);
					$m = 0;
					if($value>0){
						$m = round ((50/ $value), 4);
					}
					$c = round (100-($m*$request->adc));
					$calibration->m = $m;
					$calibration->c = -$c;
				}else{
					$calibration->adc_50 = $request->adc;
					$calibration->adc_50_datetime = $request->datetime;
				}
				
				if($calibration->save()){
					
					Session::flash('success_msg','Calibration Successfully Added'); 
					if($id>0){
						$data = array();
						$data['station_id'] = $calibration->station_id;
						$data['calibration_m'] = $calibration->m;
						$data['calibration_c'] = $calibration->c;
						Helper::awsShadow($data);
						return redirect('calibration');
					}else{
						return redirect('calibration/add/'.$calibration->id.'/'.$calibration->station_id);
					}
				}else{
					Session::flash('error_msg',"Calibration can't Add");
				}
			}			
				$stations = Station::getStation();
				$stationID = isset($request->station_id)?($request->station_id):"$stid";
				$rawdata = Rawdata::where('station_id',$stationID)
							->orderBy('datetime','DESC')
							->first();
							
				$datetime = isset($rawdata->datetime)?(date('Y-m-d H:i:s',strtotime($rawdata->datetime))):'';
				$waterlevel_meter = isset($rawdata->waterlevel_meter)?($rawdata->waterlevel_meter):0;
				$rawValue = isset($rawdata->rawValue)?($rawdata->rawValue):0;
				return view('admin.calibration.add')->with(array('stations'=>$stations,'id'=>$id,'datetime'=>$datetime,'waterlevel_meter'=>$waterlevel_meter,'rawValue'=>$rawValue,'selected_station'=>$stationID));
		}else{
			App::abort(404);
		}
	}
	
}
