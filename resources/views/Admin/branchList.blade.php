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
                        {{-- <h3 class="card-title">List of Branches</h3> --}}
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#exampleModal">
                          Add Branch
                        </button>
                      </div>
                      <div class="card-body" style="overflow-x:auto;">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                              {{-- <th>id</th> --}}
                              <th>Branch Code</th>
                              <th>Description</th>
                              <th>Address</th>
                              <th>Manager</th>
                              <th>No. of Employees</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                          </table>
                      </div>

                  </div>
                </div>
            </div>
        </div>
    </section>

        
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add New Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form name="addBranch" id="addBranch" method="POST">
              @csrf
              <div class="mb-3">
                <label for="exampleInputText" class="form-label">Branch Code</label>
                <input name="branchCode" type="text" class="form-control" id="exampleInputText">
              </div>
              <div class="mb-3">
                <label for="exampleInputText" class="form-label">Description</label>
                <input name="Description" type="text" class="form-control" id="exampleInputText">
              </div>
              <div class="mb-3">
                <label for="exampleInputText" class="form-label">Address</label>
                <input name="Address" type="text" class="form-control" id="exampleInputText">
              </div>
              <div class="mb-3">
                <label for="exampleInputText" class="form-label">Manager</label>
                <input name="Manager" type="text" class="form-control" id="exampleInputText">
              </div>
              <div class="mb-3">
                <label for="exampleInputText" class="form-label">No. of Employees</label>
                <input name="EmployeeCount" type="text" class="form-control" id="exampleInputText">
              </div>
              <button id="submit" type="submit" class="btn btn-primary">Save</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
   
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts')

{{-- bootstrap 4 --}}
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>

  $(function () {

        var dtable = $("#example1").DataTable({
          processing: true,
          serverside:true,
          ajax: "{{ route('branchTable') }}",
          columns: [
              { data: 'BranchCode' },
              { data: 'Description' },
              { data: 'Address' },
              { data: 'Manager' },
              { data: 'NoEmployees' }
          ],
          responsive: true, 
          lengthChange: false, 
          autoWidth: false,
        });
    
    
    $('#addBranch').submit(function (e) { 
      e.preventDefault();
      var form_data = $("#addBranch").serializeArray();

      $.ajax({
      type: "POST",
      url: "{{ route('addBranch') }}",
      data: form_data,
        // dataType: "dataType",
        success: function (response) {
          console.log(response.status,response.message);    
          reload();    
        }
      });
    });

    function reload(){
          dtable.ajax.reload();
        }

  });

</script>

@endsection
