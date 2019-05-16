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
use Dompdf\Dompdf;

class ServiceController extends Controller
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
        // $this->middleware('guest');
    }
  
	public function saveImage(Request $request){
		
		$station_id = isset($request['station_id'])?($request['station_id']):'';
		$station = Station::where('id',$station_id)->where('is_active',0)->first();
		if(!$station){
			return Response::json(array('result'=>false));
		}
				$stationID = $station->station_id;
		
				// $previousDaytime = date('Y/m/01 00:00:00',strtotime("-1 month"));
				// $daterange = ($previousDaytime.' - '.date('Y/m/t 23:59:59',strtotime("-1 month")));


				// $previousDaytime = date('Y/m/01 00:00:00');
				// $daterange = ($previousDaytime.' - '.date('Y/m/t 23:59:59'));

				// echo $daterange;exit;
				// $daterange = str_replace('-','to',$daterange);
				// $daterange = str_replace('/','-',$daterange);
				// $daterangeArray = explode('to',$daterange);
			
				// $starttime = trim($daterangeArray[0]);
				// $endtime = trim($daterangeArray[1]); 
				// $starttime = date('Y-m-d H:i:s',strtotime($starttime));
				// $endtime = date('Y-m-d H:i:s',strtotime($endtime));
				 // DB::enableQueryLog();
				// $allRawdataAsc = Rawdata::where('station_id',$stationID)
				// 			->whereRaw("datetime >='$starttime'")
				// 			->whereRaw("datetime <='$endtime'")
				// 			->orderBy('datetime','ASC')
				// 			->get(); 
				// echo '<pre>';print_r(DB::getQueryLog());
				
				$stationID = $stationID.date('_F_Y');
				file_put_contents("public/export/".$stationID.".png", base64_decode(explode(",", $request['data'])[1]));

				$exception_location="image: File Location :".__FILE__." Function :".__FUNCTION__." Line :".__LINE__."\n\n\n\n";
				Helper::log($exception_location);


				$nextstation = Station::whereRaw('id > '.$station_id)->where('is_active',0)->orderBy('id','ASC')->first();

				$next_station_id = (isset($nextstation['id']) && ($nextstation['id'])>0) ? ($nextstation['id']) : 0;

				echo json_encode(array('next_station_id'=>$next_station_id));


				
				// $rows = array();
				// $rows['station_id'] = array("Station ID: $station->station_id");
				// $rows['station_name'] = array("Station Name: $station->station_name");
				// $rows['datetime'] = array("Datetime :".date('F Y'));
				// $rows['heading'] = array('Datetime','Waterlevel(m)','Water level (mRL)','Rate of Change','Status');
				
				/*$html  = '<table><tr><td></td></tr><tr><th>Station ID</th><th>'.$station->station_id.'</th></tr>';
				$html  .= '<tr><th>Station Name</th><th>'.$station->station_name.'</th></tr>';
				$html  .= '<tr><th>Datetime</th><th>'.date('F Y').'</th></tr>';
				$html  .= '<tr><th>Datetime</th><th>Waterlevel(m)</th><th>Water level (mRL)</th><th>Rate of Change</th><th>Status</th><th></th></tr>';
				// echo ($allRawdataAsc);exit;
				// echo count($allRawdataAsc);
				$data = array();
				$count = count($allRawdataAsc);
				foreach($allRawdataAsc as $key=>$val){
					$statusText = ($val->maintenance_status==1)?('Maintenance'):('Running');
					$secondlastKey = ($key-1);
					if($secondlastKey<0){$secondlastKey=0;}
					$secondmrl = isset($allRawdataAsc[$secondlastKey]->waterlever_mrl)?($allRawdataAsc[$secondlastKey]->waterlever_mrl):0;
					$firstmrl = $val->waterlever_mrl;
					$rateof_change = $secondmrl-$firstmrl;
					// $data[]=array(date('d-M-Y H:i:s',strtotime($val->datetime)),$val->waterlevel_meter,$val->waterlever_mrl,$rateof_change,$statusText);
					$html  .= '<tr><td>'.date('d-m-y H:i',strtotime($val->datetime)).'</td><td>'.$val->waterlevel_meter.'</td><td>'.$val->waterlever_mrl.'</td><td>'.$rateof_change.'</td><td>'.$statusText.'</td>';
					
					$html .= '<td></td></tr>';
				}
				
				$html  .= '<tr><th></th><th></th><th></th><th></th><th></th><th><img src="public/export/'.$stationID.'.png" width="450" height="400" /></th></tr>';
				$html  .= '</td></tr></table>';
				$html  .= '</html>';
		
		
		
				// echo $html;exit;
				Excel::create($stationID, function($excel) use($stationID,$html) {

					$excel->sheet($stationID, function($sheet) use($stationID,$html){

						$sheet->loadView('admin.export')->with('stationID',$stationID)->with('html',$html);

					});
					// $excel->sheet($stationID, function($sheet) use($stationID,$html){

						// $sheet->loadView('admin.export2')->with('stationID',$stationID)->with('html',$html);

					// });

				})->download('xlsx');;*/
		
		
	}
	
	public function export(Request $request){			
	
		$station = Station::where('is_active',0)->whereIn('id',[1,2,3,4,5,6,7,8,9,10])->get();
		foreach($station as $val){
			$station_id = $val->id;
			
			echo '<br>====================<pre>';
			echo '<br>';
			echo 'http://localhost/bg/export-excel/'.$station_id;echo '<br>';
			
			$url = 'http://localhost/bg/export-excel/'.$station_id.'/true';
			$ch = curl_init($url);
			// this will prevent printing out the contents , unless you are make echo $content
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$content = curl_exec($ch);
			curl_close($ch);
			// $client = new \GuzzleHttp\Client(['headers' => null]);
			
			// $request = new Request('GET', 'http://foo.com', ['headers' => null]);
			// $client->send($request);
			
			// $request = new \GuzzleHttp\Psr7\Request('GET', 'http://tamil/120/export-excel/'.$station_id);
			// $promise = $client->sendAsync($request)->then(function ($response) {
				// echo 'I completed! ' . json_encode($response->getBody());
			// });
			// $promise->wait();
			
			/* $client = new \GuzzleHttp\Client();
			$res = $client->request('GET', 'http://tamil/120/export-excel/'.$station_id, [
				'auth' => ['admin', 'password']
			]);
			echo '<br>====================<pre>';
			echo '<br>';
			echo 'http://tamil/120/export-excel/'.$station_id;echo '<br>';
			print_r($res->getStatusCode());echo '<br>';
			print_r($res->getHeader('content-type'));echo '<br>';
			print_r($res->getBody());echo '<br>'; */
			echo '<br>====================</pre>';
		}
	}

	public function pdf(Request $request){		

		// exit;

		ini_set('max_execution_time', 30000);
		ini_set('memory_limit', '-1');	
	
		$station = Station::where('is_active',0)
								// ->whereIn('id',[1,2,3,4,5,6,7,8,9,10])
								// ->orderBy('id','ASC')
								// ->limit(5)
								->get();
		$allStations = [];
		$allStationsb = [];

		foreach($station as $val){
			
			$minmax = Station::getMinmax($val->station_id);

			$row = [];
			$row['min'] 			= $minmax['min'];
			$row['max'] 			= $minmax['max'];
			$row['station_id'] 		= $val->station_id;
			$row['station_name'] 	= $val->station_name;
			$row['copelevel'] 		= $val->copelevel;
			$row['invertlevel'] 	= $val->invertlevel;
			$row['operationlevel'] 	= $val->operationlevel;
			// $row['imgpath'] 		= 'public/export/'.$val->station_id.'_'.date('F_Y',strtotime('-1 month')).'png';
			$imgpath		 		= '/export/'.$val->station_id.'_'.date('F_Y').'.png';
			$row['imgpath'] 		= $imgpath;

			if(file_exists(public_path().$imgpath)){

				$lastChar = substr($val->station_id, -1);
				if(strtolower($lastChar)=='b'){
					$allStationsb[] = $row;
				}else{
					$allStations[] = $row;	
				}
			}

		}

		$html					=	view('admin.exportpdf')->with(array('allStations'=>$allStations));
		$path					=	public_path().'/exportpdf/';
		$file_name				=	$path.date('M-Y').'.pdf';
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->render();
		$output = $dompdf->output();
    	file_put_contents($file_name, $output);
		// Output the generated PDF to Browser
		// $dompdf->stream();

		$html					=	view('admin.exportpdf')->with(array('allStations'=>$allStationsb));
		$path					=	public_path().'/exportpdf/';
		$file_name				=	$path.date('M-Y').'_B.pdf';
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->render();
		$output = $dompdf->output();
    	file_put_contents($file_name, $output);
		// Output the generated PDF to Browser
		// $dompdf->stream();

	}
	
	public function exportPDF(Request $request,$id=0){	

		ini_set('max_execution_time', 30000);
		ini_set('memory_limit', '-1');	

		if($id<=0){

			$files = glob('public/export/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}

			$nextstation = Station::selectRaw('id')->where('is_active',0)->orderBy('id','ASC')->first();
			$id = (isset($nextstation['id']) && ($nextstation['id'])>0) ? ($nextstation['id']) : 0;
		}		
		$s1 = StationGrouping::getDisplaydata($id);	
		return view('admin.exportExcel')->with(array('s1'=>$s1));
	}

	public function exportExcel(Request $request,$id){		

		$s1 = StationGrouping::getDisplaydata($id);	

		return view('admin.exportExcel')->with(array('s1'=>$s1));

	}
	
	
	public function getDashboardrawdata(Request $request){
		
		$station_id = ($request->station_id);
		
		$stationID = Station::getStationID($station_id);

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
	
}
