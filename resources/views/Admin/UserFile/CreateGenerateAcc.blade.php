@extends('Admin.adminLayouts')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Create/Generate Account</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                  <div class="card">
                    {{-- <div class="card-header">
                    </div> --}}
                      <div class="card-body" style="overflow-x:auto;">
                        <!-- START PROGRESS BARS -->
                        <h5 class="mt-4 mb-2">Progress Bars</h5>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Progress Bars Different Sizes</h3>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                {{-- <div class="progress">
                                  <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
                                      aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Complete (success)</span>
                                  </div>
                                </div> --}}
                                <div class="progress">
                                  <div class="progress-bar"></div>
                                </div>

                                <form id="findID" method="POST">
                                  <div class="mb-3">
                                    <label for="exampleInputText" class="form-label">Enter ID here:</label>
                                    <input name="id" type="text" class="form-control" id="id">
                                  </div>
                                  <button id="submit" type="submit" class="btn btn-primary">Find</button>
                                </form>
                                
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                          </div>
                          <!-- /.col (left) -->
                          <div class="col-md-6">
                            <div class="card">
                              <div class="card-header">
                                <h3 class="card-title">Progress bars</h3>
                              </div>
                              <!-- /.card-header -->
                              <div class="card-body">
                                
                              </div>
                              <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                          </div>
                          <!-- /.col (right) -->
                        </div>                        
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
  </div>
  <!-- /.content-wrapper -->

@endsection

@section('scripts')

  <script>
    $(document).ready(function () {
      
        $('#findID').on('submit', function (e) {
            e.preventDefault();
            
            var form_data = $(this).serializeArray();

            $.ajax({
              type: "POST",
              url: "{{ route('findID') }}",
              data: form_data,
              // dataType: "dataType",
              success: function (response) {
                if (response.status > 0) {
                    simulateProcess(100);
                }else{
                    simulateProcess(10);
                }
                //  console.log(response);
              }
            });

        });

        function simulateProcess(status) {
          var progress = 0;
          // var interval = setInterval(function() {
            // progress += status; // Increase the progress by 10% for demonstration purposes
            
            // Update the progress bar width
            $('.progress-bar').css('width', status + '%');
            
            // Check if the process is complete
            // if (progress > 100) {
            //   clearInterval(interval); // Clear the interval
            // }
          // }, 1000); // 1000 milliseconds = 1 second
        }

    });
  </script>

@endsection