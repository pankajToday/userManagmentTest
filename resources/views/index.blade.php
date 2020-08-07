<!doctype html>
<html lang="en-IN">
<head>
    <title>User Management</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="csrf-token" content="CisWixwB23IqVDcjV6WMnKCFHOIVNr3sS70aUkWw">


    <link rel="stylesheet" href="{{asset('css/app_main.css')}}"/>
    <link href="{{asset('fontawesome/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome/css/solid.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>

    <!-- notifications -->
    <link rel="stylesheet" media="screen, print" href="{{asset('css/notifications/toastr/toastr.css')}}">
    <link rel="stylesheet" media="screen, print" href="{{asset('css/notifications/sweetalert2/sweetalert2.bundle.css')}}">
    <script type="application/javascript" src="{{asset('js/dataTable/jquery-3.5.1.js')}}"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <section id="main-section">
                <header id="main-header">
                    <div class="row">
                        <div class="col-xl-2 col-sm-3 col-lg-2">
                            <span class="fa-icon">
                                 <i class="fas fa-backward" style="color: #339af0;" ></i>
                            </span>

                            <span class="fa-icon">
                                 <i class="fas fa-forward" style="color: #339af0;" ></i>
                            </span>

                            <span class="fa-icon">
                                 <i class="fas fa-times "  style="color: #339af0;" ></i>
                             </span>

                            <span class="fa-icon">
                                 <i class="fas fa-home" style="color: #339af0;" ></i>
                            </span>
                        </div>

                        <div class="col-xl-8  col-sm-8 col-lg-9">
                           <input type="text" name="searchString"   id="searchString" maxlength="30"
                           class="form-control searchTextString"/>
                        </div>

                        <div class=" col-xl-2  col-sm-1 col-lg-1">
                            <button id="searchBtn" class="btn  btn-primary">
                                <i class="fas fa-search" style="color: #e3342f;" ></i> Search
                            </button>
                        </div>
                    </div>
                </header>

                <div id="breadcrumb">
                    <div class="row">
                        <div class=" col-sm-12">
                            <span id="page-title"> User Records</span>

                            <button class="btn btn-info page-right-btn"  data-toggle = "modal"
                                    data-target = ".bd-example-modal-lg"
                                    style="cursor:pointer"> Add New </button>
                        </div>
                    </div>
                </div>

                <div id="main-body">
                    <!-- content body-->
                    <table id="user-details" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Experience</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $dataCollections as $data)
                            <tr>
                                <td>
                                    <img src="{{$data['user_image']}}" width="60" height="60"
                                         class="avatar-circle" />
                                </td>
                                <td>{{ ucwords($data['name']) }}</td>
                                <td>{{$data['email']}}</td>
                                <td>{{$data['experience']}}</td>
                                <td>
                                    <button class="btn btn-danger" id="deleteBtn" onclick="deleteNow('{{$data['id']}}')">
                                        <i  class="fas fa-times-rectangle"></i> Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <!---->
                </div>


                <!-- add new user model  -->
              @include('addNewUser')


            </section>
        </div>
    </div>
</div>


<!--- main js-->
<script type="application/javascript" src="{{asset('js/dataTable/jquery-3.5.1.js')}}"></script>


<!---data table css/js -->

<script type="application/javascript" src="{{asset('js/dataTable/jquery.dataTables.min.js')}}"></script>
<script type="application/javascript" src="{{asset('js/dataTable/dataTables.bootstrap4.min.js')}}"></script>
<link href="{{asset('js/dataTable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<!---model css/js -->
<script src = "{{asset('js/4.1.3.model.bootstrap.min.js')}}"></script>
<script src = "{{asset('js/popper.min.js')}}"></script>

<!--- DatePicker -->
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />


<script src="{{asset('js/notifications/toastr/toastr.js')}}"></script>
<script src="{{asset('js/notifications/sweetalert2/sweetalert2.bundle.js')}}"></script>


<script src="{{asset('js/jquery.confirm.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#user-details').DataTable({"deferRender": true});
        $("#dialog-confirm").hide();
    } );
    $('#joinDate').datepicker({
        uiLibrary: 'bootstrap4'
    });

    $('#leaveDate').datepicker({
        uiLibrary: 'bootstrap4'
    });

    <!--- notifications -->
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 100,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    //toastr.success("No Class Diary record found.");


   function deleteNow (id) {
       $.confirm({
           text: "Are you sure you want to delete?",
           confirm: function(button) {
               $.ajax({
                   url: "{{ route('destroyUser') }}",
                   dataType: "json",
                   type: 'POST',
                   data:  {id:id},
                   headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },

                   success: function(data){
                       if( data.status == 'success')
                       {
                           toastr.success(data.message);
                           window.location="{{route('index')}}";
                       }
                       else
                       {
                           toastr.error(data.message);
                       }
                   },
                   error: function(data)
                   {
                       toastr.error("Something went wrong!");
                   }
               });
           },
           cancel: function(button) {
            //
           }
       });
   }

</script>


</body>
</html>