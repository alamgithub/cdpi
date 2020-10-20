<?php

namespace App\Http\Controllers;



namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\User;

use App\Product;

use DB;
use Image;
use Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        
    }


     /*
    *  logout
    */
    public function getSignOut() {
        Auth::logout();
      
        return redirect('admin/login');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

      return view('admin/home');
    }


    public function userform(Request $request)
    {
      //dd(auth()->guard('web')->user()); 

      $user = [];
      if($request->id){
      $user = User::where('id',$request->id)->first();
      }
      
     
      return view('admin/add-user',compact('user'));
    }



    public function validateAddUser($request)
    {
      $rqbody=$request->input();
      $validator = Validator::make($rqbody, [
          'name' => 'required|string|max:255',
          'email' => 'sometimes|required|email|unique:users,email,'.$request->id,
          'password' => 'required',
         
       ]);
       return $validator;
    }

    public function addUser(Request $request)
    {
        $resume = $pass =  $id = '';
        
        $id = $request->id;
 
       $validator  = $this->validateAddUser($request);
       if((count($validator->messages()) > 0) || ($validator->fails()))
        {
           return redirect('admin/user/'.$id)->with('errors',$validator->errors());
        }

          
        $userdata['email'] =  $request->input('email');
      
        $userdata['password'] = Crypt::encryptstring($request->input('password'));
        $userdata['name']    = $request->input('name');
        $userdata['type'] =  'u';
        $user = User::updateOrCreate(['id' => $id],$userdata);
        if($user)
         return redirect('admin/user/'. $id)->with('success', 'User data Save Successfully!');
        else
          return redirect('admin/user/'. $id)->with('fail', 'Opps! some server issue');

    }


    public function  manageUser(){

          
      $getAllData = User::where('type','u')->orderBy('id','desc')->get();
      return view('admin/manage-user',compact('getAllData'));
    
   }

    
    public function deleteUser($userid='')
    { 
        if($userid) {
        
         User::where('id',$userid)->delete();
         return redirect('admin/manage-user')->with('success', 'Employee data block Successfully!');
        }
    }



    public function product(Request $request)
    {
      $product = [];
      if($request->id)
        $product = Product::where('id',$request->id)->first();

      return view('admin/add-product',compact('product'));
      
    }



    public function validateAddProduct($request)
    {
      $rqbody=$request->input();
      $validator = Validator::make($rqbody, [
          'product_name' => 'required|string|max:255',
          'price' => 'required',
          'description' => 'required|min:20|max:255',
          'product_image' => 'mimes:jpeg,png,jpg,Webp|max:2048',
          'status' => 'required',

        ]);

       return $validator;
    }



    public function addProduct(Request $request)
    {
       
        $validator  = $this->validateAddProduct($request);
        if((count($validator->messages()) > 0) || ($validator->fails()))
        {
          return redirect('admin/product')->with('errors',$validator->errors());
        }
       
        $product_image = '';
       
        
          if($request->product_image){

            if($request->id){

              $product = Product::where('id',$request->id)->first();
              if(isset($product->product_image) && !empty($product->product_image)){
                  $path_product_image = storage_path('images').'/'.$product->product_image;
                  if(file_exists($path_product_image))
                      unlink($path_product_image);
              }
            }

          $destinationPath = storage_path('images');
          $product_image = time().'.'.$request->product_image->extension();  
          Image::make($request->product_image)->fit(200, 200)->save($destinationPath.'/'.$product_image);
        }

       
       // $request->product_image->move(storage_path('images'), $product_image);
 
        $productData['product_name'] = $request->product_name;
        $productData['price'] = $request->price;
        $productData['discount_percentage'] = $request->discount_percentage;
        $productData['description'] = $request->description;
        if($product_image)
          $productData['product_image'] = $product_image;

        $productData['status'] = $request->status;


        if($request->id)
          $id = $request->id;
        else
          $id = '';
        $product = Product::updateOrCreate(['id' => $id],$productData);

        if($product)
          return redirect('admin/product/'.$id)->with('success', 'Product data Save Successfully!');
        else
          return redirect('admin/product/'.$id)->with('fail', 'Opps! some server issue');


    }


    public function manageProduct (Request $request)
    {
      $getAllData = Product::orderBy('id','desc')->get();

       $dataUrl = 'admin/product_list_ajax';
        
        $columns  = " { data: 'product_name' },
        { data: 'price' },
        {data: 'discount_percentage'},
        { data: 'description' },
        { data: 'product_image' },
        { data: 'status' },
        { data: 'action' }";

      //return view('coupon.coupon_list',compact('dataUrl','columns'));

      return view('admin/manage-product',compact('dataUrl','columns'));
    }

    public function product_list_ajax(Request $request)
    {
      $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnName = 'id';
        $columnSortOrder  = 'desc';

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        if($columnName_arr[$columnIndex]['data'] !== 'action')
     
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

         // Total records
         
        $totalRecords = Product::select('count(*) as allcount')->count();
        DB::enableQueryLog();
        $totalRecordswithFilter = Product::select('count(*) as allcount')
                                 
                                ->where(function ($query) use ($searchValue) {

                                  $query->where('products.product_name', 'like', '%' .$searchValue . '%');
                                  $query->orwhere('products.price', 'like', '%' .$searchValue . '%');
                                
                                   
                                })->count();


        // Fetch records
       // ->leftjoin("courses",\DB::raw("FIND_IN_SET(courses.id,classes.course_id)"),">", \DB::raw("'0'"))
         $records = Product::orderBy($columnName,$columnSortOrder)
                                ->where(function ($query) use ($searchValue) {

                                  $query->where('products.product_name', 'like', '%' .$searchValue . '%');
                                  $query->orwhere('products.price', 'like', '%' .$searchValue . '%');
                                })

                   ->skip($start)
                   ->take($rowperpage)
                   ->get();

        $data_arr = array();
        $sno = $start+1;
        $string = '';
       
        foreach($records as $record){
            
            $status = 'Inactive';
            if(isset($record->status)  && $record->status == 1)
              $status = 'Active';

            $imageurl = URL::to('/../'.'storage/images/'.$record->product_image);

            $product_name = $record->product_name ?? '';
            $price = $record->price ?? '';
            $discount_percentage = $record->discount_percentage ?? '';
            $description = $record->description ?? '';
            $product_image = '<img src="'.$imageurl.'" style ="width:100px">';

            $status = '<div class="badge badge-primary">'.$status.'</div>';
           
         

            $url1 = url("admin/product/".$record->id);
            $url2 = url("admin/product/delete/".$record->id);
 
            $string = '<a href="'.$url1.'" class="btn btn-xs btn-primary btn-glow" title="Edit"><i class="fas fa-edit"></i></a><a class="btn btn-danger btn-xs" href="'.$url2.'" title="Delete">
                      <i class="fas fa-trash"></i>
                    </a>';



          $data_arr[] = array(
              "product_name" => $product_name,
              "price" => $price,
              "discount_percentage" => $discount_percentage,
              "description" => $description,
              "product_image" => $product_image,
              "status" => $status,
              "action" => $string
            );
        }
 
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "query" => DB::getQueryLog()
        );

        echo json_encode($response);
        exit;
    }


    public function deleteProduct(Request $request)
    {
      if($request->id){
        
        $product = Product::where('id',$request->id)->first();

        if(isset($product->product_image) && !empty($product->product_image)){
            $path_product_image = storage_path('images').'/'.$product->product_image;
            if(file_exists($path_product_image))
                unlink($path_product_image);
        }


        $delete = Product::where('id',$request->id)->delete();
        if($delete)
          return redirect('admin/manage-product/')->with('success', 'Product deleted Successfully!');
        else
          return redirect('admin/manage-product/')->with('fail', 'Opps! some server issue');
      }
    }



    
   


   


}
