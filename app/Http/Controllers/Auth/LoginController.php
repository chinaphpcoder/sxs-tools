<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller{
    /**
     * 登录错误代码
     */
    protected $error_code = null;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request){
        $result = $this->guard()->attempt(
            $this->credentials($request), $request->has('remember')
        );

        $user = $this->guard()->user();

        if (!empty($user)) {
            if ($user->verify == 1){
                return $result;
            }else{
                $this->error_code = $user->verify;
                $this->guard()->logout();
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request){
        if (isset($this->error_code)) {
            if ($this->error_code == 0) {
                $lang = 'auth.verify_wait';
            }else{
                $lang = 'auth.verify_stop';
            }
        }else{
            $lang = 'auth.failed';
        }
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get($lang),
            ]);
    }
}
