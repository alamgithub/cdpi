<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Product extends Model
{
    protected $fillable =['product_name','price','discount_percentage','product_image','description','status'];
   
   

}
