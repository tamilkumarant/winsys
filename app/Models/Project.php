<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Project extends Model {

	protected $table = 'bwl_project';
	
	protected $fillable = [
		'project_id',
		'project_name',
		'project_description',
		'is_active'
    ];
     
}
