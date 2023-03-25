@extends('Admin.adminLayouts')
@section('content')

@php
    // @dd($list);
@endphp

    <style>
        table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #ddd;
        }
        
        th, td {
        text-align: left;
        padding: 8px;
        }
        
        tr:nth-child(even){background-color: #f2f2f2}
    </style>

    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Branch List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List of Branches</h3>
                      </div>
                      <div class="card-body" style="overflow-x:auto;">
                        <table id="listTable" >
                            <tr>
                              <th>Branch Code</th>
                              <th>Description</th>
                              <th>Address</th>
                              <th>Manager</th>
                              <th>No. of Employees</th>
                            </tr>
                            @foreach ($list as $branch ) 
                            <tr>
                                <td>{{ $branch->BranchCode }}</td>
                                <td>{{ $branch->Description }}</td>
                                <td>{{ $branch->Address }}</td>
                                <td>{{ $branch->Manager }}</td>
                                <td>{{ $branch->NoEmployees }}</td>
                            </tr>
                            @endforeach
                          </table>
                      </div>

                  </div>
                </div>
            </div>
        </div>
    </section>
   
  </div>
  <!-- /.content-wrapper -->

@endsection
