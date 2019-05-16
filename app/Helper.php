<?php namespace App;

use App\Models\MenuAccess;
use App\Models\Users;
use App\Models\ContactPerson;
use App\Helper\AppHelper;
use Auth;
use DB;
use Mail;
use Config;
use URL;

class Helper {
	
    
    public static function SendMail($email='',$subject='',$data='') {
        
        Mail::send('emails.send_mail', $data, function($message)
                        use($email,$subject){
          			$message->from('no-reply@ivaluesoft.com', 'IValue Soft');
          			$message->to($email)->subject($subject);
          		});

                         
        return 'true';
    }

    public static function randomPassword($chars = 8) {
	   $letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	   return substr(str_shuffle($letters), 0, $chars);
	}
	
    public static function checkAuthFunction($id,$field='view') { 
		$role_id='';
		if(Auth::user()){
			$role_id=Auth::user()->user_role;
		}		
		if($role_id){
			$count=MenuAccess::where('role_id','=',$role_id)->where('menu_id','=',$id)->where($field,'=',1)->count();
			return $count;
		}else{
			return null;
		}
	}
	public static function percentage($percentage,$totalWidth){
		return ($percentage / 100) * $totalWidth;		
	}
	public static function p($data,$exit=true){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		if($exit==true){
			exit;
		}
	}
	public static function downloadCSV($array, $filename = "export", $delimiter=",") {
		
		$filename .= '.csv'; 
		
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		
		$f = fopen('php://output', 'w');

		foreach ($array as $line) {
			fputcsv($f, $line, $delimiter);
		}
	}
	
	public static function awsShadow($params){

		// Helper::p($params);
		
		$station_id = (isset($params['pub_id']) && ($params['pub_id'])!='' )?($params['pub_id']):'';
		if($station_id){
						
			$location = (isset($params['location']) && ($params['location'])!='' )?($params['location']):'';
			$cope_level = (isset($params['cope_level']) && ($params['cope_level'])!='' )?($params['cope_level']):'';
			$invert_level = (isset($params['invert_level']) && ($params['invert_level'])!='' )?($params['invert_level']):'';
			// $calibration_m = (isset($params['calibration_m']) && ($params['calibration_m'])!='' )?($params['calibration_m']):'';
			// $calibration_c = (isset($params['calibration_c']) && ($params['calibration_c'])!='' )?($params['calibration_c']):'';
			$offset_o = (isset($params['offset_o']))?($params['offset_o']):'';
			// $delta = (isset($params['delta']) && ($params['delta'])!='' )?($params['delta']):'';
			// $spike_threshold = (isset($params['spike_threshold']) && ($params['spike_threshold'])!='' )?($params['spike_threshold']):'';
			$maintenance = (isset($params['mode']) && ($params['mode'])!='' )?($params['mode']):('');
			$b1 = (isset($params['b1'])  )?($params['b1']):'';
			$b2 = (isset($params['b2'])  )?($params['b2']):'';
			$b3 = (isset($params['b3'])  )?($params['b3']):'';
			$b4 = (isset($params['b4'])  )?($params['b4']):'';
			$b5 = (isset($params['b5'])  )?($params['b5']):'';
			$h1 = (isset($params['h1'])  )?($params['h1']):'';
			$h2 = (isset($params['h2'])  )?($params['h2']):'';
			$h3 = (isset($params['h3'])  )?($params['h3']):'';
			$h4 = (isset($params['h4'])  )?($params['h4']):'';
			$h5 = (isset($params['h5'])  )?($params['h5']):'';
			$w1 = (isset($params['w1'])  )?($params['w1']):'';
			$w2 = (isset($params['w2'])  )?($params['w2']):'';
			$w3 = (isset($params['w3'])  )?($params['w3']):'';
			$w4 = (isset($params['w4'])  )?($params['w4']):'';
			$w5 = (isset($params['w5'])  )?($params['w5']):'';
			
			$args =  '?pub_id='.urlencode($station_id);
			$args .=  '&location='.urlencode($location);
			$args .=  '&cope_level='.urlencode($cope_level);
			$args .=  '&invert_level='.urlencode($invert_level);
			// $args .=  '&calibration_m='.urlencode($calibration_m);
			// $args .=  '&calibration_c='.urlencode($calibration_c);
			$args .=  '&offset_o='.urlencode($offset_o);
			// $args .=  '&delta='.urlencode($delta);
			// $args .=  '&spike_threshold='.urlencode($spike_threshold);
			$args .=  '&mode='.urlencode($maintenance);
			$args .=  '&b1='.urlencode($b1);
			$args .=  '&b2='.urlencode($b2);
			$args .=  '&b3='.urlencode($b3);
			$args .=  '&b4='.urlencode($b4);
			$args .=  '&b5='.urlencode($b5);
			$args .=  '&h1='.urlencode($h1);
			$args .=  '&h2='.urlencode($h2);
			$args .=  '&h3='.urlencode($h3);
			$args .=  '&h4='.urlencode($h4);
			$args .=  '&h5='.urlencode($h5);
			$args .=  '&w1='.urlencode($w1);
			$args .=  '&w2='.urlencode($w2);
			$args .=  '&w3='.urlencode($w3);
			$args .=  '&w4='.urlencode($w4);
			$args .=  '&w5='.urlencode($w5);
			
		/* 	 $file = fopen("mytest.txt","w");
			echo fwrite($file,date('d-M-Y H:i:s')."\n\n helper awsShadow args".json_encode($args));
			fclose($file); */

			// Helper::p($args);
			
			$url = URL::to('shadowManage.php'.($args));
			Helper::getWebpage($url);
			
			
			
			
		} 
		
	}
	
	public static function getWebpage( $url ) {
		
		/* $file = fopen("mytest.txt","w");
		echo fwrite($file,date('d-M-Y H:i:s')."\n\n getwebpage ".json_encode($url));
		fclose($file);  */
		
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "spider", // who am i
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}
	public static function convertToHoursMins($time, $format = '%02d hr %02d min') {
		if ($time < 1) {
			return;
		}
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		return sprintf($format, $hours, $minutes);
	}
	
	public static function getMinutesFromDates($start_time,$end_time){
		$minutes=0;
		if($start_time && $end_time){
			$start_time = date('Y-m-d H:i:s',strtotime($start_time));
			$end_time = date('Y-m-d H:i:s',strtotime($end_time));
			$from_time = strtotime($start_time);
			$to_time = strtotime($end_time);
			$minutes=round(abs($to_time - $from_time) / 60);
			if($minutes<0){
				$minutes=0;
			}
		}
		return $minutes;		
	} 

	#$filename = Filename(without date)Eg. snaptoroad                    
	#$message = to be write in logfile                                   
	#$logtype = ERROR, INFO                                              
	public static function log($message,$filename='LOG', $logtype='INFO'){
			$date = date( 'Y-m-d H:i:s');
			$file = $filename.'_'.date('d_m_Y').".log";
			$filename = "public/logger/";

			if(!is_dir($filename)) {
				if(!file_exists($filename)){
					mkdir($filename,0777,true);
				}			
			}			

			$filename = $filename.$file;
			if (file_exists($filename)) {
					file_put_contents($filename, "[$date][$logtype]\t\t$message\n", FILE_APPEND);
			} else {
					$fp = fopen($filename,"w+");
					fwrite($fp,"[$date][$logtype]\t\t$message\n");
					fclose($fp);
					chmod($filename, 0777);
			}
			return true;
	}

	public static function makeDirectory($path, $permission = 0777) {
		    //print_r($path);exit;	        
        $path = 'public/'.$path.'/';
        if(!is_dir($path)) {
           if(!file_exists($path)){
               
                // $old = umask(0);
                $isCreated = mkdir($path,$permission);  
				//print_r($isCreated);exit;				 
                // umask($old);
               
                if($isCreated) {
                    // return true;
                } else {
                    // return false;
                 }
           }else{
             // return true;
           }
         } else {
           // return false;
         }
    }
	
	
}