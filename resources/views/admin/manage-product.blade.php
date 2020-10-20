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
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Manage Users</h3>

            @if(session('success'))
            <div class="alert alert-success text-center">
              {{session('success')}}
            </div>
            @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table  class="table table-bordered table-striped" id="dataTable">
                <thead>
                <tr>
               
                 <th>Product Name</th>
                 <th>Price</th>
                 <th>Discount</th>
                 <th>Description</th>
                 <th>Image</th>
                 <th>Status</th>
                 <th>Action</th>

                </tr>
                </thead>
               {{-- <tbody>
                  

                @if(!empty($getAllData))
                @foreach($getAllData as $key => $row)

                <tr>

                  <td>{{$row->product_name ?? ''}}</td>
                  <td>{{$row->price ?? ''}}</td>
                  <td>{{$row->discount_percentage ?? ''}}</td>
                  <td>{{$row->description ?? ''}}</td>
                  <td><img src="{!! URL::to('/../'.'storage/images/'.$row->product_image) ?? '' !!}" style ="width:100px"> </td>
                  <td>
                    @if(isset($row->status) && $row->status == 1)
                    {{' Enabled'}}
                    @else
                    {!! 'Disabled' !!}
                    @endif
                  </td>
             
                
                <td class="project-actions text-right">
                       
                    <a class="btn btn-info btn-sm" href="{{ url('admin/product/'.$row->id) }}">
                      <i class="fas fa-pencil-alt"></i> Edit
                    </a>

                    <a class="btn btn-danger btn-sm" href="{{ url('admin/product/delete/'.$row->id) }}">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                     
                  </td> 
                </tr>
               @endforeach
               @endif
                
                </tbody>
                --}}
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @endsection

