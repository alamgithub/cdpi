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
              <li class="breadcrumb-item active">User</li>
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
            
           
            @if(session('success'))
            <div class="alert alert-success">
              {{session('success')}}
            </div>
            @endif


            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Add User</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <form role="form" action="{{url('admin/add-user')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <input type="hidden" name = "id"  value="@if(isset($user->id)){{$user->id}} @endif">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Name</label>

                        <input name = "name" type="text" class="form-control" placeholder="Enter ..." value="@if(isset($user->name)){{$user->name}} @endif">
                      </div>
                    </div>

                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Email ID</label>
                        <input type="Email"  name = "email" class="form-control" placeholder="Enter ..." value="@if(isset($user->email)){{$user->email}} @endif">
                      </div>
                    </div>
                   
                  </div>
                   <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password"  name = "password" class="form-control" placeholder="Enter ..." value="">
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


