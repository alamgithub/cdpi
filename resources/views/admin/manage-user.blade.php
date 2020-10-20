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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
               
                 <th>Name</th>
                 <th>Email ID</th>
                 <th>Action</th>

                </tr>
                </thead>
                <tbody>
                  

                @if(!empty($getAllData))
                @foreach($getAllData as $key => $row)

                <tr>

                  <td>{{$row->name ?? ''}} 
                  
                  </td>
              
                  <td>{{$row->email ?? ''}}</td>
                
                <td class="project-actions text-right">
                       
                    <a class="btn btn-info btn-sm" href="{{ url('admin/user/'.$row->id) }}">
                      <i class="fas fa-pencil-alt"></i>Edit
                    </a>
                     
                  </td> 
                </tr>
               @endforeach
               @endif
                
                </tbody>
                
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

