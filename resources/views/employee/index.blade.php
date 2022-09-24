<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <style>
      #indeximg{
        height: 70px;
        width: 70px;
      }
      #showimg{
        height: 150px;
        width: 150px;
      }
      #editimg{
        height: 300px;
        width: 300px;
      }
    
    </style>
</head>
<body>
    <div class="container">
    <div class="row mb-3 mt-5">
       <div class="col-lg-6">
          <h3>User Records</h3>
       </div>
       <div class="col-lg-6 d-flex justify-content-lg-end align-items-center">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
           Add New</button>
        </div>
    </div>
    <!-- {{-- Begin::Employee listing table --}} -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Profile Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Experience</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{$employee->id}}</td>
                <td>
                <img src="{{\Illuminate\Support\Facades\Storage::url($employee->image)}}" alt="" class="rounded-circle" id="indeximg">
                </td>
                <td>{{$employee->name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->experience}}</td>
                <td>
                <a data-toggle="modal" id="smallButton" data-target="#smallModal" data-attr="{{ route('employee.delete',$employee->id) }}" title="Delete Project">
                    <i class="fa fa-times text-danger  fa-lg" aria-hidden="true"><span class="ml-2">Remove</span></i>
                </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- {{-- End::Employee listing table --}} -->
</div>
    

<!--Begin::Create Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" class="text-center">Add New Record<span class="text-danger">*</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="display:none"></div>
                <form method="post" action="{{ route('employee.store') }}" enctype="multipart/form-data">
                    @csrf
                     <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>  
                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Email
                            <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="email" id="email">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="date_of_joining" class="col-sm-4 col-form-label">Date Of Joining
                            <span class="text-danger">*</span></label>
                        <div class="col-sm-6">
                          <input type="date" class="form-control" name="date_of_joining" id="date_of_joining">
                        </div>
                    </div>
                    <div class="row gx-3 gy-2 align-items-center">
                        <div class="col-sm-4">
                            <label class="visually-hidden" for="date_of_leaving">Date Of Leaving
                                <span class="text-danger">*</span></label> 
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                            <div></div>
                                <input type="date" class="form-control" name="date_of_leaving" id="date_of_leaving" >
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="still_working" id="still_working">
                              <label class="form-check-label" for="still_working">
                                Still Working
                              </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row mt-3">
                        <label for="image" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                          <input type="file" name="image" id="image" class="form-control"  >
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="formSubmit">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End::Create Modal -->

<script>
    $(document).ready(function(){
        $('#formSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/employee/store') }}",
                method: 'post',
                data: {
                    name: $('#name').val(),
                    email: $('#email').val(),
                    date_of_joining: $('#date_of_joining').val(),
                    date_of_leaving: $('#date_of_leaving').val(),
                    still_working: $('#still_working').val(),
                    image: $('#image').val()
                },
                success: function(result){
                    if(result.errors)
                    {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value){
                            $('.alert-danger').show();
                            $('.alert-danger').append('<li>'+value+'</li>');
                        });
                    }
                    else
                    {
                        $('.alert-danger').hide();
                        $('#exampleModal').modal('hide');
                    }
                }
            });
        });
    });
</script>
<script>
    // display a modal (small modal)
    $(document).on('click', '#smallButton', function(event) {
        if(confirm('Are you sure you want to delete this Record?')==false){
            e.preventDefault();
        }
        // event.preventDefault();
        let href = $(this).attr('data-attr');
        $.ajax({
            url: href, 
            type: 'GET',
            dataType: 'html',
            // return the result
            success:function(response) {
               location.reload();
            }
            // , complete: function() {
            //     $('#loader').hide();
            // }
            , error: function(jqXHR, testStatus, error) {
                console.log(error);
                alert("Page " + href + " cannot open. Error:" + error);
                $('#loader').hide();
            }
            , timeout: 8000
        })
    });

</script>
</body>
</html>
