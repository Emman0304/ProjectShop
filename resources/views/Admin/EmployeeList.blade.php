@extends('Admin.adminLayouts')
@section('content')

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
            <h1 class="m-0">Employee List</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li> --}}
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
                        <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#employeeModal">
                        Add New Employee
                        </button>
                    </div>
                    <div class="card-body" style="overflow-x:auto;">
                        <div class="table-responsive">
                        <table id="empTable" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>ID No.</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Branch</th>
                                <th></th>
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
        </div>
    </section>

    @component('components.modal',['modal_id' => 'employeeModal','title' => 'Add New Employee','form_id' => 'addEmployee','size' => 'modal-lg'])
    
        <div class="mb-3">
            <input name="id" type="hidden" class="form-control" id="id">

            <label for="exampleInputText" class="form-label">Branch</label>
            {{-- <input name="branchCode" type="text" class="form-control" id="branchCode" required> --}}
            <select name="branchCode" id="branchCode" class="form-control" required>
              <option value="">Select Branch</option>
              @foreach ( $branches as $branch )
                <option value="{{ $branch->BranchCode }}">{{ $branch->Description }}</option>
              @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Position</label>
            {{-- <input name="Position" type="text" class="form-control" id="Position" required> --}}
            <select name="Position" id="Position" class="form-control" required>
              <option value="">Select Position</option>
              @foreach ( $positions as $pos )
                <option value="{{ $pos->PositionCode }}">{{ $pos->Description }}</option>
              @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Last Name</label>
            <input name="LName" type="text" class="form-control" id="LName" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">First Name</label>
            <input name="FName" type="text" class="form-control" id="FName" required>
        </div>  
        <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>M.I.</label>
                <input name="MName" id="MName" type="text" class="form-control">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>Suffix</label>
                <input name="Suffix" id="Suffix" type="text" class="form-control" >
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Age</label>
                <input name="Age" id="Age" type="number" class="form-control" required >
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label>Contact No.</label>
                <input name="contactNo" id="contactNo" type="number"  class="form-control" required >
              </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Email</label>
                    <input name="email" id="email" type="email"  class="form-control" required >
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Address</label>
            <input name="Address" type="text" class="form-control" id="Address" required>
        </div>

        <button id="submit" type="submit" class="btn btn-primary">Save</button>

    @endcomponent
    </div>
    <!-- /.content-wrapper -->

@endsection

@section('scripts')

<script>

  $(document).ready(function () {
  
        var dtable = $("#empTable").DataTable({
          processing: true,
          serverside:true,
          ajax: "{{ route('employeeTable') }}",
          // responsive: true, 
          lengthChange: false, 
          autoWidth: false,
          ordering: false,
          rowCallback : function(row,data,DisplayIndex){

            $(row).find('.edit').unbind('click').on('click',function(){
              id = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: "{{ route('editEmployee') }}",
                data:{
                  id:id
                },
                // dataType: "dataType",
                success: function (response) {
                  if (response.status > 0) {
                      $('#id').val(response.data.id);
                      $('#branchCode').val(response.data.BranchCode);
                      $('#Position').val(response.data.Position);
                      $('#LName').val(response.data.LName);
                      $('#FName').val(response.data.FName);
                      $('#MName').val(response.data.MName);
                      $('#Suffix').val(response.data.Suffix);
                      $('#Address').val(response.data.Address);
                      $('#contactNo').val(response.data.ContactNo);
                      $('#Age').val(response.data.Age);
                      $('#email').val(response.data.Email);
                      $("#employeeModal").modal('show');
                    }
                }
              });

            });

            $(row).find('.delete').unbind('click').on('click',function(){
              id = $(this).attr('data-id');

              Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                    
                  $.ajax({
                      type: "POST",
                      url: "{{ route('deleteEmployee') }}",
                      data: {
                        id:id
                      },
                      // dataType: "dataType",
                      success: function (response) {
                        if (response.status > 0) {
                            Swal.fire(
                              'Deleted!',
                              response.message,
                              'success'
                            )
                            reload();

                        }
                      }
                  });
                }
              })         
            });   
          }
        });
    
    function reload(){
          dtable.ajax.reload();
        }


    $('#addEmployee').submit(function (e) { 
      e.preventDefault();
      var form_data = $("#addEmployee").serializeArray();

      $.ajax({
      type: "POST",
      url: "{{ route('AddEmployee') }}",
      data: form_data,
        // dataType: "dataType",
        success: function (response) {
          if (response.status > 0) {
            Swal.fire(
              response.message,
              '',
              'success'
            ).then((ok) => {
              $("#employeeModal").modal('hide');
              reload();   
            });
          }else{
            Swal.fire(
              response.message,
              '',
              'warning'
            )
          }       
        }
      });
    });


    $('#employeeModal').on('hide.bs.modal', function () {
          $('#id').val('');
          $('#branchCode').val('');
          $('#Position').val('');
          $('#LName').val('');
          $('#FName').val('');
          $('#Age').val('');
          $('#email').val('');
          $('#MName').val('');
          $('#Suffix').val('');
          $('#Address').val('');
          $('#contactNo').val('');
        });


  });

</script>

@endsection