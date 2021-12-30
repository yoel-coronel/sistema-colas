<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Oracle\AdmUsuario;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repository\AuthRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    private $authRepository = null;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthRepository $authRepository)
    {
        $this->middleware('guest')->except('logout');
        $this->authRepository = $authRepository;
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $this->validateActiveDirectory($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @throws ValidationException
     */
    public function validateActiveDirectory($request){

        try {
            $domain =env('LOCAL_DOMAIN','fovipol.gob.pe');
            $link = ldap_connect($domain);
            if(! $link) {
            }
            ldap_set_option($link, LDAP_OPT_PROTOCOL_VERSION, 3); // Recommended for AD
            if (! ldap_bind($link, $request->name."@".$domain, $request->password)) {
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                $this->username() => [trans('auth.failed')],
            ]);
        }
        $this->registerUserActiveDirectory($request);
    }

    /**
     * @throws ValidationException
     */
    public function registerUserActiveDirectory($request){

        $user = User::where('name',$request->name)->first();

        if($user){
            $user->update([
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
        }else{
            $userOracle = $this->authRepository->findOracleAdmUser($request->name);

            if($userOracle){
                User::create([
                    'name' => $request->name,
                    'email' => $request->name."@".env('LOCAL_DOMAIN','fovipol.gob.pe'),
                    'full_name'=> $userOracle->persona->nomb_comp_per,
                    'password' => Hash::make($request->password),
                ]);

            }else{

                throw ValidationException::withMessages([
                    $this->username() => [trans('auth.failed')],
                ]);

            }
        }



    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }


}
