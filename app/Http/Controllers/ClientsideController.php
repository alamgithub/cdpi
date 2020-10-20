<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Product;
use Crypt;
use Validator;
use Response;
use DB;




class ClientsideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function home()
    {
       
        return view('webfront.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function signup()
    {
      
        return view('webfront.signup', compact('data'));
    }

    public function postregister(Request $request)
    {
       
        $validate = validator($request->all(), [
           
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'contact' => 'required|numeric|unique:users',
            'password' => 'required|max:15|min:6',
            'c_password' => 'required|same:password', 
           
        ],['name.required' => 'The first name field is required','c_password.required' => 'The confirm password field is required.','c_password.same' =>'The confirm password and password must match.']);
        if ($validate->fails()) {
            return redirect('signup')->withErrors($validate)->withInput();
        }
        


        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->contact = $request->input('contact');
        $user->password = Crypt::encryptString($request->input('password'));
        $user->type =  'c';
        $user->last_name =   $request->input('last_name');
        $user->contact =   $request->input('contact');
        $user->save();
      
       

        if($user->id)
            return redirect('signup')->with('success', 'User data Save Successfully!');
        else
          return redirect('signup')->with('fail', 'Opps! some server issue');
        
        

    }

    public function login()
    {
        $mobileNumber = FALSE;
        return view('webfront.login', compact('mobileNumber'));
    }


    public function postLogin(Request $request)
    {
        $validate = validator($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);


        if ($validate->fails()) {
            return redirect('login')->withErrors($validate)->withInput();
        }  else{

           $user = User::where(['email'=> $request->input('email'),'type' => 'c'])->first();
           // $password =  Crypt::encryptString($request->input('password'));
        
           if ($user == null) {
             // code...
             $validate->errors()->add('email','Invalid email-id');
             goto error;
           }else{
            $password = Crypt::decryptString($user->password);
             if ($password != $request->input('password')) {
               $validate->errors()->add('password','Invalid Password');
               goto error;
             }else{
               
                 \Auth ::login($user);
               //  $role = Auth::user()->role;

                return redirect()->to('/product');
                
              

                return redirect()->to('/home')->except('logout');
               }

             }

          // }

         }



        error:
         $input = Input::except('password'); //Get all the old input except password.
              $input['autoOpenModal'] = 'true'; //Add the auto open indicator flag as an input.
              return redirect()->back()
              ->withErrors($validate)
              ->withInput($input);

      
        return redirect('login')->with('fail', 'Invalid User name or password');
       
    }



    public function product()
    {
        if(!auth()->guard('web')->user()){
          return redirect('login');  
        }
        $products  = Product::where(['status' => 1])
                    ->orderBy('id', 'desc')->simplePaginate(5);
       
        return view('webfront.product',['products' => $products]);
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        
        return redirect('home');
    }



}
