@extends('webfront.app')

@section('content')


<!-- Third Container (Grid) -->
<div class="container bg-3 text-center">    
  <h3 class="margin">Products</h3><br>
  <div class="row">
    @if($products)
     @foreach($products as $k => $product)
    <div class="col-sm-4">
      <h3>{!! $product->product_name ?? '' !!}</h3>
      <p>{!! $product->description ?? '' !!}</p>
      <img src="{!! URL::to('/../'.'storage/images/'.$product->product_image) ?? '' !!}" class="img-responsive margin" style="width:100%" alt="Image">
    </div>
   @endforeach
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-3 col-sm-4 col-xs-12 col-md-offset-5">
           {{ $products->links() }}
      </div>
    </div>
    @endif
  </div>
</div>

@endsection