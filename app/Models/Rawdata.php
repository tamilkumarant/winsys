<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Rawdata extends Model {

	protected $table = 'raw_data';
    
	protected $fillable = [
		'station_id',
		'datetime',
		'waterlevel_meter',
		'waterlever_mrl',
		'battery_voltage',
		'maintenance_status'
    ];
}
