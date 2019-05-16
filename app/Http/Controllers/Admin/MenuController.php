<?php

/*namespace App\Http\Controllers\Admin;

use App\User;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Menu;
use App\Models\MenuAccess;
use App\Models\Role;
use Auth;
use Redirect;
use Hash;
use App;

class MenuController extends Controller
{
    

   
    protected $redirectTo = '/dashboard';

    
    public function __construct()
    {
        // $this->middleware('auth');
    }
  */
    

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
use Auth;
use Redirect;
use Hash;
use App;
use Session;
use Response;

class MenuController extends Controller
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
  
	
	public function menu(Request $request){
		echo 'tamil';exit;
		// $checkAuth=Helper::checkAuthFunction(5,'view');
		// if($checkAuth){
		// 	$menu=Menu::selectRaw('id,menu,is_active')->orderBy('id','desc')->get();
		// 	return view('admin.menu.menu')->with(array('menu'=>$menu));
		// }else{
		// 	App::abort(404);
		// }
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
