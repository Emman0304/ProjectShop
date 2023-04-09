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
                        <div class="table-responsive">
                          <table id="example1" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Branch ID</th>
                                <th>Branch Code</th>
                                <th>Description</th>
                                <th>Address</th>
                                <th>Manager</th>
                                <th>No. of Employees</th>
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

    @component('components.modal',['modal_id' => 'exampleModal','title' => 'Add New Branch','form_id' => 'addBranch'  ])
      
      <div class="mb-3">
        <input name="id" type="hidden" class="form-control" id="id">

        <label for="exampleInputText" class="form-label">Branch Code</label>
        <input name="branchCode" type="text" class="form-control" id="branchCode" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Description</label>
        <input name="Description" type="text" class="form-control" id="Description" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Address</label>
        <input name="Address" type="text" class="form-control" id="Address" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Manager</label>
        <input name="Manager" type="text" class="form-control" id="Manager" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">No. of Employees</label>
        <input name="EmployeeCount" type="number" class="form-control" id="EmployeeCount" required>
      </div>
      <button id="submit" type="submit" class="btn btn-primary">Save</button>

    @endcomponent
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts')

<script>

  $(document).ready(function () {
  
        var dtable = $("#example1").DataTable({
          processing: true,
          serverside:true,
          ajax: "{{ route('branchTable') }}",
          // responsive: true, 
          lengthChange: false, 
          autoWidth: false,
          ordering: false,
          rowCallback : function(row,data,DisplayIndex){

            $(row).find('.edit').unbind('click').on('click',function(){
              id = $(this).attr('data-id');

              $.ajax({
                type: "POST",
                url: "{{ route('editBranch') }}",
                data:{
                  id:id
                },
                // dataType: "dataType",
                success: function (response) {
                  if (response.status > 0) {
                      $('#id').val(response.data.id);
                      $('#branchCode').val(response.data.BranchCode);
                      $('#Description').val(response.data.Description);
                      $('#Address').val(response.data.Address);
                      $('#Manager').val(response.data.Manager);
                      $('#EmployeeCount').val(response.data.NoEmployees);
                      $("#exampleModal").modal('show');
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
                      url: "{{ route('deleteBranch') }}",
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


    $('#addBranch').submit(function (e) { 
      e.preventDefault();
      var form_data = $("#addBranch").serializeArray();

      $.ajax({
      type: "POST",
      url: "{{ route('addBranch') }}",
      data: form_data,
        // dataType: "dataType",
        success: function (response) {
          if (response.status > 0) {
            Swal.fire(
              response.message,
              '',
              'success'
            ).then((ok) => {
              $("#exampleModal").modal('hide');
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


    $('#exampleModal').on('hide.bs.modal', function () {
          $('#id').val('');
          $('#branchCode').val('');
          $('#Description').val('');
          $('#Address').val('');
          $('#Manager').val('');
          $('#EmployeeCount').val('');
        });


  });

</script>

@endsection
