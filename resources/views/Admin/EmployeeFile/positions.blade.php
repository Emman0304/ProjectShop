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
            <h1 class="m-0">Positions/Roles</h1>
          </div><!-- /.col -->
          {{-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div> --}}
          <!-- /.col -->
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
                        <button type="button" class="btn btn-primary float-sm-right" data-toggle="modal" data-target="#position">
                          Create Position
                        </button>
                      </div>
                      <div class="card-body" style="overflow-x:auto;">
                        <div class="table-responsive">
                          <table id="positions" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th>Position Code</th>
                                <th>Description</th>
                                <th>Role</th>
                                <th>Created By</th>
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

    @component('components.modal',['modal_id' => 'position','title' => 'Add Position/Role','form_id' => 'addPosition'  ])
      
      <div class="mb-3">
        <input name="id" type="hidden" class="form-control" id="id">

        <label for="exampleInputText" class="form-label">Position Code</label>
        <input name="positionCode" type="text" class="form-control" id="positionCode" required>
      </div>
      <div class="mb-3">
        <label for="exampleInputText" class="form-label">Description</label>
        <input name="Description" type="text" class="form-control" id="Description" required>
      </div>
      <div class="form-group">
        <label>Role</label>
        <textarea name="Role" id="Role" class="form-control" rows="3" placeholder="" required></textarea>
      </div>
      <button id="submit" type="submit" class="btn btn-primary">Save</button>

    @endcomponent
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts')

<script>

  $(document).ready(function () {
  
        var dtable = $("#positions").DataTable({
          processing: true,
          serverside:true,
          ajax: "{{ route('positionTable') }}",
          // responsive: true, 
          lengthChange: false, 
          autoWidth: false,
          ordering: false,
          rowCallback : function(row,data,DisplayIndex){

            $(row).find('.edit').unbind('click').on('click',function(){
              id = $(this).attr('data-id');
              $.ajax({
                type: "POST",
                url: "{{ route('editPosition') }}",
                data:{
                  id:id
                },
                // dataType: "dataType",
                success: function (response) {
                  if (response.status > 0) {
                      $('#id').val(response.data.id);
                      $('#positionCode').val(response.data.PositionCode);
                      $('#Description').val(response.data.Description);
                      $('#Role').val(response.data.Role);
                      $("#position").modal('show');
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
                      url: "{{ route('deletePosition') }}",
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


    $('#addPosition').submit(function (e) { 
      e.preventDefault();
      var form_data = $("#addPosition").serializeArray();

      $.ajax({
      type: "POST",
      url: "{{ route('addPosition') }}",
      data: form_data,
        // dataType: "dataType",
        success: function (response) {
          if (response.status > 0) {
            Swal.fire(
              response.message,
              '',
              'success'
            ).then((ok) => {
              $("#position").modal('hide');
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


    $('#position').on('hide.bs.modal', function () {
          $('#id').val('');
          $('#positionCode').val('');
          $('#Description').val('');
          $('#Role').val('');
        });


  });

</script>

@endsection