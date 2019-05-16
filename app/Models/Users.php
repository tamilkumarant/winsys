<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use DB;
class Users extends Model {

	protected $table = 'users';
    
	protected $fillable = [
		'name',
		'username',
		'email',
		'password',
		'password_text',
		'mobile',
		'user_role',
		'project_id',
		'is_active'
    ];
}
