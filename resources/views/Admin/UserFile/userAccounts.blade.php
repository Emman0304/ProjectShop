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
        <h1 class="m-0">User Accounts</h1>
      </div>
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
                    <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#addUser">
                      Add User
                    </button>
                  </div>
                  <div class="card-body" style="overflow-x:auto;">
                    <div class="table-responsive">
                      <table id="UsersTable" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Main Branch</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Position</th>
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
</div>
<!-- /.content-wrapper -->

    @component('components.modal',['modal_id' => 'addUser','title' => 'Add New User','form_id' => 'addUserForm'  ])
        <div class="mb-3">
            <input name="id" type="hidden" class="form-control" id="id">

            <label for="exampleInputText" class="form-label">Branch</label>
            <select class="form-control" name="Branch" id="Branch" required>
                {!! $branches !!}
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Name</label>
            <input name="Name" type="text" class="form-control" id="Name" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Position</label>
            <select class="form-control" name="Position" id="Position" required>
                {!! $positions !!}
            </select>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Username</label>
            <input name="Username" type="text" class="form-control" id="Username" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Email</label>
            <input name="Email" type="text" class="form-control" id="Email" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Password</label>
            <input name="Password" type="password" class="form-control" id="Password" required>
        </div>
        <div class="mb-3">
            <label for="exampleInputText" class="form-label">Confirm Password</label>
            <input name="Confirm_Password" type="password" class="form-control" id="confPass" required>
        </div>
        <button id="submit" type="submit" class="btn btn-primary">Save</button>
    @endcomponent

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            
            var dtable = $("#UsersTable").DataTable({
                processing: true,
                serverside:true,
                ajax: "{{ route('usersTable') }}",
                // responsive: true, 
                lengthChange: false, 
                autoWidth: false,
                ordering: false,
                rowCallback : function(row,data,DisplayIndex){
                    
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
                                    url: "{{ route('deleteUser') }}",
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

            $('#addUserForm').submit(function (e) { 
                e.preventDefault();

                var form_data = $('#addUserForm').serializeArray();
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('addUser') }}",
                    data: form_data,
                    // dataType: "dataType",
                    success: function (response) {
                        if (response.status > 0) {
                            Swal.fire(
                                response.message,
                                '',
                                'success'
                            ).then((ok) => {
                                $("#addUser").modal('hide');
                                reload();   
                            });
                        }else{
                            var errors = response.message;
                            var errorMsg = '<ul>';
                            $.each(errors, function (key, value) {
                                errorMsg += '<li>' + value + '</li>';
                            });
                            errorMsg += '</ul>';

                            Swal.fire(
                                errorMsg,
                                '',
                                'warning'
                            )
                        }                            
                    }
                });
                
            });

            function reload(){
                dtable.ajax.reload();
            }

            $('#addUser').on('hide.bs.modal', function () {
                $('#id').val('');
                $('#Branch').val('');
                $('#Name').val('');
                $('#Position').val('');
                $('#Username').val('');
                $('#Email').val('');
            });

        });
    </script>
@endsection