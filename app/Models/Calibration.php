<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Helper;
use App\Models\Station;

use DB;


class Calibration extends Model {

	protected $table = 'calibration';
    
	protected $fillable = [
		'station_id',
		'adc_50',
		'adc_100',
		'm',
		'c',
		'datetime'
    ];
	
}

