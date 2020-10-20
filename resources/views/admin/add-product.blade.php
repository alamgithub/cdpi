@extends('admin.layouts.app')
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-3"></div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
            <!-- general form elements disabled -->

              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if(isset($imageerrors)) 
              @if ($imageerrors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($imageerrors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          @endif


            @if(session('success'))
            <div class="alert alert-success">
              {{session('success')}}
            </div>
            @endif


            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Add Product</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="{{url('admin/add-product')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <input type="hidden" name = "id"  value="{!! $product->id ?? '' !!}">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Product Name</label>

                        <input name = "product_name" type="text" class="form-control" placeholder="Enter ..." value="{!! $product->product_name ?? '' !!}">
                      </div>
                    </div>

                     <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Status</label>
                        <select id = "status" name="status" class="form-control">
                         
                        <option value="1" >Enabled</option>
                        <option value="0">Disable</option>

                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number"  name = "price" class="form-control" placeholder="Enter ..." value="{!! $product->price ?? '' !!}">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Discount percentage</label>
                        <input type="number"  name = "discount_percentage" class="form-control" placeholder="Enter ..." value="{!! $product->discount_percentage ?? '' !!}">
                      </div>
                    </div>
                   
                  </div>
                   <div class="row">
                    
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Product Image</label>
                        <input type="file"  name="product_image" class="form-control" >
                      </div>
                      @if(isset($product->product_image))
                      <img src="{!! URL::to('/../'.'storage/images/'.$product->product_image) ?? '' !!}" style ="width:100px">
                      @endif
                    </div>

                     <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description">{!! $product->description ?? ''!!}</textarea>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- general form elements disabled -->
           
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection


