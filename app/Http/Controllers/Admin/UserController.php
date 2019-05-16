<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Users;
use App\Models\Project;
use App\Models\Station;
use App\Models\UserStation;
use App\Models\Menu;
use App\Models\MenuAccess;
use Auth;
use Redirect;
use Hash;
use App;
use Session;
use Response;

class UserController extends Controller
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
		$checkAuth=Helper::checkAuthFunction(4,'view');
		if($checkAuth){
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			if($user_role==1){
				$users=Users::selectRaw('users.id,users.name,users.username,users.password_text,roles.name as role_name,users.is_active')
						->join('roles','roles.id','=','users.user_role')->orderBy('users.id','desc')->get();
			}else if($user_role==2){	
				$stationList=UserStation::selectRaw('stid')->where('uid',$user_id)->groupBy('stid')->get();
				$stid = array();
				foreach($stationList as $key=>$value){
					$stid[] = $value->stid;
				}				
				$users=Users::selectRaw('users.id,users.name,users.username,users.password_text,roles.name as role_name,users.is_active')
						->join('roles','roles.id','=','users.user_role')
						->join('bwl_user_station','bwl_user_station.uid','=','users.id')
						->whereIn('bwl_user_station.stid',$stid)
						->where('users.user_role','<>','1')
						->orderBy('users.id','desc')
						->groupBy('users.id')
						->get();
			}else{
				$users=Users::selectRaw('users.id,users.name,users.username,users.password_text,roles.name as role_name,users.is_active')
						->join('roles','roles.id','=','users.user_role')
						->where('users.id',$user_id)
						->where('users.user_role','<>','1')
						->orderBy('users.id','desc')
						->get();			
			}
			return view('admin.users.index')->with(array('users'=>$users));
		}else{
			App::abort(404);
		}
	}
	public function add(Request $request){
		
		$checkAuth=Helper::checkAuthFunction(4,'add');
		if($checkAuth){				
			if($request->isMethod('post')){				
				$data=$request->all();
				$username = $request->username; 
				$project_id = $request->project_id; 
				$userDetails = User::where('username',$username)->where('project_id',$project_id)->first();
				if($userDetails){					
					Session::flash('error_msg',"Users already exist!");
					return redirect()->back();
				}
				$data['password'] = Hash::make($request->password_text);
				$user = Users::create($data);
				$user_id = $user->id;
				if($user_id){ 
					$station = $request->station;
					foreach($station as $key=>$value){
						$userStation = UserStation::where('stid',$value)->where('uid',$user_id)->first();
						if(!$userStation){
							$input = array('stid'=>$value,'uid'=>$user_id);
							UserStation::create($input);
						}
					}
					Session::flash('success_msg','Users Successfully Added');
					return redirect()->back();
				}else{
					Session::flash('error_msg',"Users can't Add");
					return redirect()->back();
				}
			}else{	
				$roles = Role::get();
				$station=Station::where('is_active',0)->orderBy('id','desc')->get();
				$project=Project::where('is_active',0)->orderBy('id','desc')->get();
				return view('admin.users.add')->with(array('roles'=>$roles,'station'=>$station,'project'=>$project));
			}
		}else{
			App::abort(404);
		}
	}
	public function edit(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(4,'edit');
		if($checkAuth){						
			$users=Users::find($id);
			if($request->isMethod('post')){
				$data=$request->all();
				$username = $request->username; 
				$project_id = $request->project_id; 
				$userDetails = User::where('username',$username)->where('project_id',$project_id)->where('id','<>',$id)->first();
				if($userDetails){					
					Session::flash('error_msg',"Users already exist!");
					return redirect()->back();
				}
				$data['password'] = Hash::make($request->password_text);
				if($users->fill($data)->save()){
					$deleteUserStation = UserStation::where('uid',$id)->delete();					
					$station = $request->station;
					foreach($station as $key=>$value){
						$userStation = UserStation::where('stid',$value)->where('uid',$id)->first();
						if(!$userStation){
							$input = array('stid'=>$value,'uid'=>$id);
							UserStation::create($input);
						}
					}
					Session::flash('success_msg', 'Users Successfully Updated'); 
					return redirect()->back();
				}else{					
					Session::flash('error_msg', "Users can't Update!"); 
					return redirect()->back();	
				}
			}else{			
				$roles = Role::get();
				$project=Project::where('is_active',0)->orderBy('id','desc')->get();
				$station=Station::where('is_active',0)->orderBy('id','desc')->get();
				$stationList = UserStation::selectRaw('stid')->where('uid',$id)->get();
				$list = array();
				foreach($stationList as $key=>$val){
					$list[] = (string)$val->stid;
				}
				return view('admin.users.edit')->with(array('users'=>$users,'roles'=>$roles,'project'=>$project,'station'=>$station,'stationList'=>$list));
			}
		}else{
			App::abort(404);
		}
	}
	public function deleteRow(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(4,'delete');
		if($checkAuth){						
			$users=Users::find($id);
			if($users->delete()){
				Session::flash('success_msg','Users Successfully Deleted');
				return redirect()->back();
			}else{
				Session::flash("Users can't Delete");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	public function status(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(4,'edit');
		if($checkAuth){						
			$users=Users::find($id); 
			$users->is_active=($users->is_active==0)?1:0; 
			if($users->save()){ 
				Session::flash('success_msg','Users Successfully Status Changed');
				return redirect()->back();
			}else{
				Session::flash("Users can't Status Change");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	
	public function getStations($id){
		$station=Station::where('project_id',$id)->where('is_active',0)->orderBy('id','desc')->get();
		$data = array();
		foreach($station as $key=>$val){
			$data[]=(object)array('id'=>$val->id,'text'=>$val->station_name);
		}
		return Response::json($data);
	}

	public function menu(Request $request){
		// echo 'tamil';exit;
		$checkAuth=Helper::checkAuthFunction(5,'view');
		if($checkAuth){
			$menu=Menu::selectRaw('id,menu,is_active')->orderBy('id','desc')->get();
			return view('admin.menu.menu')->with(array('menu'=>$menu));
		}else{
			App::abort(404);
		}
	}

	public function addMenu(Request $request){

		echo 'tamil2';exit;
		
		$checkAuth=Helper::checkAuthFunction(5,'add');
		if($checkAuth){
			if($request->isMethod('post'))	{

				$menu_name=trim($request->menu);
				$is_active=trim($request->is_active);
				$is_active=($is_active==1)?0:1;
				if($menu_name){				
					$getRole = Menu::where('menu',$menu_name)->first();
					if($getRole){
						return redirect()->back()->with('error_msg',"Menu Already Exist! can't Add.");
					}else{
						$menu = new Menu;           
						$menu->menu = $menu_name;					
						$menu->is_active = $is_active;				
						if($menu->save()){
							return redirect()->back()->with('success_msg','Menu Successfully Added');
						}else{
							return redirect()->back()->with('error_msg',"Menu can't Add");	
						}
					}
				}else{
					return redirect()->back()->with('error_msg',"Menu can't Add");	
				}
				
			}else{
				return view('admin.menu.addMenu');
			}
		}else{
			App::abort(404);
		}
			
			
	}  
	public function editMenu(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(5,'edit');
		if($checkAuth){
			if($request->isMethod('post'))	{

				$menu_name=trim($request->menu);
				$is_active=trim($request->is_active);
				$is_active=($is_active==1)?0:1;
				if($menu_name){				
					$getRole = Menu::where('menu',$menu_name)->where('id','!=',$id)->first();
					if($getRole){
						return redirect()->back()->with('error_msg',"Menu Already Exist! can't Add.");
					}else{
						$menu = Menu::find($id);           
						$menu->menu = $menu_name;					
						$menu->is_active = $is_active;						
						if($menu->save()){
							return redirect()->back()->with('success_msg','Menu Successfully Updated');
						}else{
							return redirect()->back()->with('error_msg',"Menu can't Update");	
						}
					}
				}else{
					return redirect()->back()->with('error_msg',"Menu can't Update");	
				}
				
			}else{
				$menu=Menu::where('id',$id)->first();
				return view('admin.menu.editMenu')->with(array('menu'=>$menu));
			}
		}else{
			App::abort(404);
		}
			
			
	}  
	
	public function deleteMenu($id){	
		$checkAuth=Helper::checkAuthFunction(5,'delete');
		if($checkAuth){	
			$menu = Menu::find($id);           
			$menu->is_active = 1;							
			if($menu->save()){
				return redirect()->back()->with('success_msg','Menu Successfully Deleted');
			}else{
				return redirect()->back()->with('error_msg',"Menu can't Delete");	
			}
		}else{
			App::abort(404);
		}
	}
	
	public function menuAccess(Request $request,$id=''){
		$checkAuth=Helper::checkAuthFunction(6,'view');
		if($checkAuth){	
			if(!$id){
				$id=Auth::user()->user_role;
			}
			if($request->isMethod('post'))	{
				
					$success='';
					$view=$request->view;
					$add=$request->add;
					$edit=$request->edit;
					$delete=$request->delete;
					$getAll=MenuAccess::select('id')->where('role_id','=',$id)->get();
					foreach($getAll as $key=>$val){
						$menu=MenuAccess::find($val->id); 
						$menu->view=0;
						$menu->add=0;
						$menu->edit=0;
						$menu->delete=0;
						$menu->save();
					}
					
					if(is_array($view)){
						foreach($view as $key=>$val){
							$getId = MenuAccess::select('id')->where('menu_id',$val)->where('role_id','=',$id)->first();
							if($getId){
								$access=MenuAccess::find($getId->id);						
								if(!$access){
									$access=new MenuAccess;
								}
							}else{
								$access=new MenuAccess;
							}
							$access->menu_id=$val;
							$access->role_id=$id;
							$access->view=1;					
							$success=$access->save();
						}
					}
					if(is_array($add)){
						foreach($add as $key=>$val){
							$getId = MenuAccess::select('id')->where('menu_id',$val)->where('role_id','=',$id)->first();
							if($getId){
								$access=MenuAccess::find($getId->id);						
								if(!$access){
									$access=new MenuAccess;
								}
							}else{
								$access=new MenuAccess;
							}
							$access->menu_id=$val;
							$access->role_id=$id;
							$access->add=1;					
							$success=$access->save();
						}
					}
					if(is_array($edit)){
						foreach($edit as $key=>$val){
							$getId = MenuAccess::select('id')->where('menu_id',$val)->where('role_id','=',$id)->first();
							if($getId){
								$access=MenuAccess::find($getId->id);						
								if(!$access){
									$access=new MenuAccess;
								}
							}else{
								$access=new MenuAccess;
							}
							$access->menu_id=$val;
							$access->role_id=$id;
							$access->edit=1;					
							$success=$access->save();
						}
					}
					if(is_array($delete)){
						foreach($delete as $key=>$val){
							$getId = MenuAccess::select('id')->where('menu_id',$val)->where('role_id','=',$id)->first();
							if($getId){
								$access=MenuAccess::find($getId->id);						
								if(!$access){
									$access=new MenuAccess;
								}
							}else{
								$access=new MenuAccess;
							}
							$access->menu_id=$val;
							$access->role_id=$id;
							$access->delete=1;					
							$success=$access->save();
						}
					}
					if($success){
							return redirect()->back()->with('success_msg','Menu Access Successfully Updated');
					}else{
						return redirect()->back()->with('error_msg',"Menu Access can't Update");	
					}
				
			}else{
				$menu=Menu::selectRaw('menu.id,menu.menu,ma.role_id,ma.view,ma.add,ma.edit,ma.delete')
							->leftjoin('menu_access as ma',function($join)use($id){
								$join->on('ma.menu_id','=','menu.id')
									->where('ma.role_id','=',$id);
							})
							->where('menu.is_active',0)
							->get();
				$role = Role::selectRaw('id,name')->where('is_active',0)->get();
						
				return view('admin.menu.menuAccess')->with(array('menu'=>$menu,'roles'=>$role,'role_id'=>$id));
			}
		}else{
			App::abort(404);
		}
			
	}
	
	
}
