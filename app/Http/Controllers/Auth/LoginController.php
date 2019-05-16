<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout', 'authenticate']);
    }
	
	public function login(Request $request)
    {		
		$email = trim($request->username);
		$password = trim($request->password);
        if (Auth::attempt(['username' => $email, 'password' => $password,'admin_access'=>1,'is_active'=>0])) {
            return redirect()->intended('dashboard');
        }else{
			return redirect('login')->with('error_msg','Invalid Login Credentials. Please try again.');
		}
    }
	
	public function logout() {
        Auth::logout();
        return redirect('login');
    }
}
