<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Log;
use Crypt;
use Illuminate\Support\Facades\Input;

class SignInController extends Controller
{
    //
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
    //  protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     //protected $redirectTo = 'administrator';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
     

    }

   
    public function login(Request $request)
    {

       
         $request_array = $request->all();
         $x = Validator::make($request_array,[
           'email' =>'required',
           'password' => 'required',
         ]);



         if ($x->fails() || (count($x->messages()) >0)) {
           // code...
           goto error;
         }else{

           $user = User::where(['email' => $request->input('email'),'type' => 'u'])->first();
           // $password =  Crypt::encryptString($request->input('password'));
        
           if ($user == null) {
             // code...
             $x->errors()->add('email','Invalid email-id');
             goto error;
           }else{
            $password = Crypt::decryptString($user->password);
             if ($password != $request->input('password')) {
               $x->errors()->add('password','Invalid Password');
               goto error;
             }else{
               
                 \Auth ::login($user);
               //  $role = Auth::user()->role;

                return redirect()->to('admin/home');
                
              

                 return redirect()->to('admin/home')->except('logout');
               }

             }

          // }

         }

         error:
         $input = Input::except('password'); //Get all the old input except password.
              $input['autoOpenModal'] = 'true'; //Add the auto open indicator flag as an input.
              return redirect()->back()
              ->withErrors($x)
              ->withInput($input);
    }


   
}
