<x-admin-master>
    @section('sidenav')
        <x-sidenav link="manage_trashes">
        </x-sidenav>
    @endsection


    @section('content')
        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
{{--            <!-- Navbar -->--}}
{{--            <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">--}}
{{--                <div class="container-fluid py-1 px-3">--}}
{{--                    <nav aria-label="breadcrumb">--}}
{{--                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">--}}
{{--                            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>--}}
{{--                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tables</li>--}}
{{--                        </ol>--}}
{{--                        <h6 class="font-weight-bolder mb-0">Tables</h6>--}}
{{--                    </nav>--}}
{{--                    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">--}}
{{--                        <div class="ms-md-auto pe-md-3 d-flex align-items-center">--}}
{{--                            <div class="input-group input-group-outline">--}}
{{--                                <label class="form-label">Type here...</label>--}}
{{--                                <input type="text" class="form-control">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <ul class="navbar-nav  justify-content-end">--}}
{{--                            <li class="nav-item d-flex align-items-center">--}}
{{--                                <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">--}}
{{--                                    <i class="fa fa-user me-sm-1"></i>--}}
{{--                                    <span class="d-sm-inline d-none">Sign In</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">--}}
{{--                                <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">--}}
{{--                                    <div class="sidenav-toggler-inner">--}}
{{--                                        <i class="sidenav-toggler-line"></i>--}}
{{--                                        <i class="sidenav-toggler-line"></i>--}}
{{--                                        <i class="sidenav-toggler-line"></i>--}}
{{--                                    </div>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item px-3 d-flex align-items-center">--}}
{{--                                <a href="javascript:;" class="nav-link text-body p-0">--}}
{{--                                    <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item dropdown pe-2 d-flex align-items-center">--}}
{{--                                <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                    <i class="fa fa-bell cursor-pointer"></i>--}}
{{--                                </a>--}}
{{--                                <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">--}}
{{--                                    <li class="mb-2">--}}
{{--                                        <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                            <div class="d-flex py-1">--}}
{{--                                                <div class="my-auto">--}}
{{--                                                    <img src="{{asset('vendor/material_admin/img/team-2.jpg')}}" class="avatar avatar-sm  me-3 ">--}}
{{--                                                </div>--}}
{{--                                                <div class="d-flex flex-column justify-content-center">--}}
{{--                                                    <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                                        <span class="font-weight-bold">New message</span> from Laur--}}
{{--                                                    </h6>--}}
{{--                                                    <p class="text-xs text-secondary mb-0">--}}
{{--                                                        <i class="fa fa-clock me-1"></i>--}}
{{--                                                        13 minutes ago--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="mb-2">--}}
{{--                                        <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                            <div class="d-flex py-1">--}}
{{--                                                <div class="my-auto">--}}
{{--                                                    <img src="{{asset('vendor/material_admin/img/small-logos/logo-spotify.svg')}}" class="avatar avatar-sm bg-gradient-dark  me-3 ">--}}
{{--                                                </div>--}}
{{--                                                <div class="d-flex flex-column justify-content-center">--}}
{{--                                                    <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                                        <span class="font-weight-bold">New album</span> by Travis Scott--}}
{{--                                                    </h6>--}}
{{--                                                    <p class="text-xs text-secondary mb-0">--}}
{{--                                                        <i class="fa fa-clock me-1"></i>--}}
{{--                                                        1 day--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li>--}}
{{--                                        <a class="dropdown-item border-radius-md" href="javascript:;">--}}
{{--                                            <div class="d-flex py-1">--}}
{{--                                                <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">--}}
{{--                                                    <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">--}}
{{--                                                        <title>credit-card</title>--}}
{{--                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
{{--                                                            <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">--}}
{{--                                                                <g transform="translate(1716.000000, 291.000000)">--}}
{{--                                                                    <g transform="translate(453.000000, 454.000000)">--}}
{{--                                                                        <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>--}}
{{--                                                                        <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>--}}
{{--                                                                    </g>--}}
{{--                                                                </g>--}}
{{--                                                            </g>--}}
{{--                                                        </g>--}}
{{--                                                    </svg>--}}
{{--                                                </div>--}}
{{--                                                <div class="d-flex flex-column justify-content-center">--}}
{{--                                                    <h6 class="text-sm font-weight-normal mb-1">--}}
{{--                                                        Payment successfully completed--}}
{{--                                                    </h6>--}}
{{--                                                    <p class="text-xs text-secondary mb-0">--}}
{{--                                                        <i class="fa fa-clock me-1"></i>--}}
{{--                                                        2 days--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </nav>--}}
{{--            <!-- End Navbar -->--}}

            <!-- Start Alert -->
            <div class="container-fluid py-4">
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-light">{{$error}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-text text-light">{{\Session::get('success')}}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(\Session::has('delete'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-text text-light">{{\Session::get('delete')}}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            <!--End Alert -->

            <div class="container-fluid py-4">
              <!-- Start Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                    <h6 class="text-white text-capitalize ps-3">Manage Trashes</h6>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive p-0">

                                    <table class="table align-items-center justify-content-center mb-0">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-outline-success mx-3" data-bs-toggle="modal" data-bs-target="#addTrashModal">
                                            <span class="btn-inner--text">Add Trash</span>
                                            <span class="btn-inner--icon"><i class="material-icons">add_task</i></span>
                                        </button>
                                        <thead>
                                        <tr>..
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trash</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Points</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Unit</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($trashes as $trash)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2">
                                                            <div>
                                                                <img src="{{asset('img/'.$trash->image)}}" class="avatar avatar-xl rounded-circle me-2" alt="spotify">
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0 text-sm">{{$trash->name}}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-sm font-weight-bold">{{$trash->trashCategory->name}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">TP {{$trash->points}}</span>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs font-weight-bold">{{$trash->unit}}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <form method="POST" action="{{action([\App\Http\Controllers\TrashController::class, 'destroy'], ['trash' => $trash])}}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="button" class="btn btn-success btn-sm">Edit</button>
                                                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- End Table -->
                <footer class="footer py-4  ">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <div class="copyright text-center text-sm text-muted text-lg-start">
                                    © <script>
                                        document.write(new Date().getFullYear())
                                    </script>,
                                    made with <i class="fa fa-heart"></i> by
                                    <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Carja Tech</a>
                                    for a better web.
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Carja Tech</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </main>

            <!-- Modal -->
            <div class="modal fade" id="addTrashModal" tabindex="-1" role="dialog" aria-labelledby="addTrashModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body p-0">
                            <div class="card card-plain">
                                <div class="card-header pb-0 text-left">
                                    <h5 class="">Add Trash</h5>
                                </div>
                                <form id="addTrashForm" method="POST" action="{{ action([\App\Http\Controllers\TrashController::class, 'store']) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body pb-3">
                                            <div class="row">
                                                <div class="col-md-12 mb-4">
                                                    <div class="input-group input-group-static">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Select Category</label>
                                                        <select name="trash_category_id" class="form-control" id="exampleFormControlSelect1">
                                                            @foreach($categories as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-4">
                                                    <div class="input-group input-group-dynamic">
                                                        <label class="form-label">Name</label>
                                                        <input name="name" type="text" class="form-control" />
                                                    </div>
                                                    <span class="text-danger error-text name_error"></span>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="input-group input-group-dynamic">
                                                        <label class="form-label">Points</label>
                                                        <input name="points" type="text" class="form-control">
                                                    </div>
                                                    <span class="text-danger error-text points_error"></span>
                                                </div>
                                                <div class="col-md-6 mb-4">
                                                    <div class="input-group input-group-dynamic">
                                                        <label class="form-label">Unit</label>
                                                        <input name="unit" type="text" class="form-control">
                                                    </div>
                                                    <span class="text-danger error-text unit_error"></span>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="input-group mt-2">
                                                        <label class="input-group-text" for="image">Upload</label>
                                                        <input type="file" name="image" id="image">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="card-footer text-center pt-0 px-sm-4 px-1">
                                        <button type="submit" class="btn bg-gradient-primary btn-lg w-100">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    @endsection

    @section('ajaxFunctions')
            <script>
                $(function(){
                    // Add new trash
                    $('#addTrashForm').on('submit', function(e){

                        var form = this;
                        var formData = new FormData(form);
                        if(formData.get('name') == ''){
                            e.preventDefault();
                            $(form).find('span.name_error').text("Name cannot be empty");
                        }
                        if(! $.isNumeric(formData.get('points'))){
                            e.preventDefault();
                            $(form).find('span.points_error').text("Points must be a number");
                        }
                        if(formData.get('points') == ''){
                            e.preventDefault();
                            $(form).find('span.points_error').text("Points cannot be empty");
                        }
                        if(formData.get('unit') == ''){
                            e.preventDefault();
                            $(form).find('span.unit_error').text("Unit cannot be empty");
                        }

                        // var form = this;
                        // $.ajax({
                        //     url: $(form).attr('action'),
                        //     method: $(form).attr('method'),
                        //     data: new FormData(form),
                        //     processData: false,
                        //     contentType: false,
                        //     beforeSend: function(){
                        //         $(form).find('span.error-text').text('');
                        //     },
                        //     success: function(data) {
                        //         console.log(data.data)
                        //         $(form)[0].reset();
                        //     },
                        //     error: function(error) {
                        //         $.each(error.responseJSON.errors, function(prefix, val){
                        //             $(form).find("span."+prefix+"_error").text(val);
                        //         });
                        //     }
                        // })
                    })


                });
            </script>
        @endsection
</x-admin-master>
