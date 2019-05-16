<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class UserStation extends Model {

	protected $table = 'bwl_user_station';
    
	protected $fillable = [
		'stid',
		'uid'
    ];
}
