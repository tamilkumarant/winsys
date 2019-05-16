<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\Models\Project;
use Auth;
use Redirect;
use Hash;
use App;
use Session;

class ProjectController extends Controller
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
		$checkAuth=Helper::checkAuthFunction(2,'view');
		if($checkAuth){
			$user_id = Auth::user()->id; 
			$user_role = Auth::user()->user_role; 
			if($user_role==1){
				$project=Project::orderBy('id','desc')->get();
			}else{				
				$project=Project::join('bwl_station','bwl_station.project_id','=','bwl_project.id')
						->join('bwl_user_station','bwl_user_station.stid','=','bwl_station.id')
						->where('bwl_user_station.uid',$user_id)
						->groupBy('bwl_project.id')
						->orderBy('bwl_project.id','desc')
						->get();
			}
			
			return view('admin.project.index')->with(array('project'=>$project));
		}else{
			App::abort(404);
		}
	}
	public function add(Request $request){
		
		$checkAuth=Helper::checkAuthFunction(2,'add');
		if($checkAuth){				
			if($request->isMethod('post')){				
				$data=$request->all();
				if(Project::create($data)){ 
					Session::flash('success_msg','Project Successfully Added');
					return redirect()->back();
				}else{
					Session::flash('error_msg',"Project can't Add");
					return redirect()->back();
				}
			}else{	
				return view('admin.project.add');
			}
		}else{
			App::abort(404);
		}
	}
	public function edit(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'edit');
		if($checkAuth){						
			$project=Project::find($id);
			if($request->isMethod('post')){
				$data=$request->all();
				if($project->fill($data)->save()){
					Session::flash('success_msg', 'Project Successfully Updated'); 
					return redirect()->back();
				}else{					
					Session::flash('error_msg', "Project can't Update!"); 
					return redirect()->back();	
				}
			}else{			
				return view('admin.project.edit')->with(array('project'=>$project));
			}
		}else{
			App::abort(404);
		}
	}
	public function deleteRow(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'delete');
		if($checkAuth){						
			$project=Project::find($id);
			if($project->delete()){
				Session::flash('success_msg','Project Successfully Deleted');
				return redirect()->back();
			}else{
				Session::flash("Project can't Delete");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	public function status(Request $request,$id){
		
		$checkAuth=Helper::checkAuthFunction(2,'edit');
		if($checkAuth){						
			$project=Project::find($id);
			$project->is_active=($project->is_active==0)?1:0;
			if($project->save()){
				Session::flash('success_msg','Project Successfully Status Changed');
				return redirect()->back();
			}else{
				Session::flash("Project can't Status Change");
				return redirect()->back();
			}
		}else{
			App::abort(404);
		}
	}
	
}
