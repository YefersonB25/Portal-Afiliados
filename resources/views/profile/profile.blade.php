@extends('layouts.app')

@section('content')
	<body class="ltr app sidebar-mini light-mode">
        <!--app-content open-->
        <div class="app-content main-content mt-0">
            <div class="side-app">
                <!-- CONTAINER -->
                <div class="main-container container-fluid">

                    <!-- ROW-1 OPEN -->
                    <div class="row" id="user-profile">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12 col-xl-6">
                                            <div class="d-flex flex-wrap align-items-center">
                                                <div class="profile-img-main rounded">
                                                    <img src="{{asset("$userInfo->photo")}}" alt="avatar" class="avatar avatar-xl rounded">
                                                </div>
                                                <div class="ms-4">
                                                    <h4>{{$userInfo->name}}</h4>
                                                    {{-- <p class="text-muted mb-2">Member Since: November 2020</p>
                                                    <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-rss"></i> Follow</a>
                                                    <a href="mail-inbox.html" class="btn btn-secondary btn-sm"><i class="fa fa-envelope"></i> E-mail</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-xl-6">
                                            <div class="d-md-flex flex-wrap justify-content-lg-end">
                                                {{-- <div class="media m-3">
                                                    <div class="media-icon bg-primary me-3 mt-1">
                                                        <i class="fe fe-file-plus fs-20 text-white"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="text-muted">Posts</span>
                                                        <div class="fw-semibold fs-25">
                                                            328
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="media m-3">
                                                    <div class="media-icon bg-info me-3 mt-1">
                                                        <i class="fe fe-users  fs-20 text-white"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="text-muted">Usuarios asociados</span>
                                                        <div class="fw-semibold fs-25">
                                                            {{$countUserAsociado}}
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="media m-3">
                                                    <div class="media-icon bg-warning me-3 mt-1">
                                                        <i class="fe fe-wifi fs-20 text-white"></i>
                                                    </div>
                                                    <div class="media-body">
                                                        <span class="text-muted">Following</span>
                                                        <div class="fw-semibold fs-25">
                                                            2,876
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-top">
                                    <div class="wideget-user-tab">
                                        <div class="tab-menu-heading">
                                            <div class="tabs-menu1">
                                                <ul class="nav">
                                                    <li><a href="#profileMain" class="active show" data-bs-toggle="tab">Perfil</a></li>
                                                    <li><a href="#editProfile" data-bs-toggle="tab">Editar Perfil</a></li>
                                                    <li><a href="#friends" data-bs-toggle="tab">UsuariosAsociados</a></li>
                                                    <li><a href="#accountSettings" data-bs-toggle="tab">Registrar Usuario</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active show" id="profileMain">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            {{-- <div class="p-5">
                                                <h3 class="card-title">Biodata</h3>
                                                <p class="text-dark-light">Hi I'm Teri Dactyl,has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.</p>
                                                <div>
                                                    <div>
                                                        <h5 class="text-dark text-14 mb-0">Lead designer / Developer</h5>
                                                        <a href="javascript:void(0)" class="text-primary">websitenamename.com</a>
                                                        <p class="mb-2 mt-3"><b>2010-2015</b></p>
                                                        <p class="text-muted text-14">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                    </div>

                                                    <div>
                                                        <h5 class="text-dark text-14 mb-0">Senior Graphic Designer</h5>
                                                        <a href="javascript:void(0)" class="text-primary">samplewebsite.com</a>
                                                        <p class="mb-2 mt-3"><b>2007-2009</b></p>
                                                        <p class="text-muted text-14 mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="border-top"></div>
                                            <div class="table-responsive p-5">
                                                <h3 class="card-title">Personal Info</h3>
                                                <table class="table row table-borderless">
                                                    <tbody class="col-lg-12 col-xl-6 p-0">
                                                        <tr>
                                                            <td><strong>Full Name :</strong>{{$userInfo->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Email :</strong> {{$userInfo->email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Phone :</strong> {{empty($userInfo->telefono) ? '0000000000' : $userInfo->telefono}} </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td><strong>Location :</strong> USA</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Languages :</strong> English, German, Spanish</td>
                                                        </tr> --}}
                                                    </tbody>
                                                    {{-- <tbody class="col-lg-12 col-xl-6 p-0 border-top-0"> --}}
                                                        {{-- <tr>
                                                            <td><strong>Website :</strong> websitename.com</td>
                                                        </tr> --}}

                                                    {{-- </tbody> --}}
                                                </table>
                                            </div>
                                            {{-- <div class="border-top"></div>
                                            <div class="p-5">
                                                <h3 class="card-title">Statistics</h3>
                                                <div class="profile-cover__info ms-4 ms-auto p-0">
                                                    <ul class="nav p-0 border-bottom-0 mb-0">
                                                        <li class="border p-2 br-5 bg-light-lightest wpx-100 hpx-70 text-center my-1">
                                                            <span class="border-0 mb-0 pb-0 fs-21">113</span>
                                                            Projects
                                                        </li>
                                                        <li class="border p-2 br-5 bg-light-lightest wpx-100 hpx-70 text-center mx-2 my-1">
                                                            <span class="border-0 mb-0 pb-0 fs-21">245</span>
                                                            Followers
                                                        </li>
                                                        <li class="border p-2 br-5 bg-light-lightest wpx-100 hpx-70 text-center my-1">
                                                            <span class="border-0 mb-0 pb-0 fs-21">128</span>
                                                            Following
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="border-top"></div>
                                            <div class="p-5">
                                                <h3 class="card-title">Contact</h3>
                                                <div class="d-sm-flex">
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-primary-transparent text-primary"> <i class="fe fe-phone fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Mobile</span>
                                                                    <p class="mb-0"> +245 354 654 </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-success-transparent text-success"> <i class="fe fe-slack fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Slack</span>
                                                                    <p class="mb-0"> @spruko.w </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-info-transparent text-info"> <i class="fe fe-map-pin fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Current Address</span>
                                                                    <p class="mb-0"> San Francisco, CA </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="border-top"></div>
                                            <div class="p-5">
                                                <h3 class="card-title">Social</h3>
                                                <div class="d-md-flex">
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-primary-transparent text-primary"> <i class="fe fe-github fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Github</span>
                                                                    <p class="mb-0"> <a href="javascript:void(0)" class="text-default">github.com/spruko</a> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-success-transparent text-success"> <i class="fe fe-twitter fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Twitter</span>
                                                                    <p class="mb-0"> <a href="javascript:void(0)" class="text-default">twitter.com/spruko.me</a> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="main-profile-contact-list">
                                                            <div class="media mx-2">
                                                                <div class="media-icon bg-info-transparent text-info"> <i class="fe fe-linkedin fs-21"></i> </div>
                                                                <div class="media-body ms-2">
                                                                    <span class="text-muted">Linkedin</span>
                                                                    <p class="mb-0"> <a href="javascript:void(0)" class="text-default">linkedin.com/in/spruko</a> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="editProfile">
                                    <div class="card">
                                        <div class="card-body border-0">
                                            <form class="form-horizontal" method="post" action="{{route('profile.update', $userInfo->id)}}" novalidate>
                                                @csrf
                                                {{ method_field('PUT') }}
                                                <div class="row mb-4">
                                                    <p class="mb-4 text-17">Personal Info</p>
                                                    <div class="col-md-12 col-lg-12 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="email" class="form-label">email</label>
                                                            <input type="text" name="pfEmail" id="pfEmail" class="form-control" tabindex="3" value="{{$userInfo->email}}" onInput="validarInput()">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-lg-12 col-xl-6">
                                                        <div class="form-group">
                                                            <label for="phone" class="form-label">Phone</label>
                                                            <input type="text" name="pfTelefono" id="pfTelefono" class="form-control" tabindex="3" value="{{$userInfo->telefono}}" onInput="validarInput()">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary" id="btnPrEditSave">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="tab-pane" id="timeline">
                                    <div class="row row-sm">
                                        <div class="col-12">
                                            <div class="card border">
                                                <div class="card-header border-bottom d-block p-4">
                                                    <div class="media overflow-visible">
                                                        <div class="media-user me-2">
                                                            <div class="main-img-user"><img alt="" class="rounded-circle avatar-md" src="../assets/images/faces/6.jpg"></div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span> </div>
                                                        <div class="ms-auto">
                                                            <div class="dropdown show main-contact-star">
                                                                <a class="new option-dots2" data-bs-toggle="dropdown" href="JavaScript:void(0);"><i  class="fe fe-more-vertical  tx-18"></i></a>
                                                                <div class="dropdown-menu shadow">
                                                                    <a class="dropdown-item" href="#">Edit Post</a>
                                                                    <a class="dropdown-item" href="#">Delete Post</a>
                                                                    <a class="dropdown-item" href="#">Personal Settings</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                                    <div class="row row-sm">
                                                        <div class="col">
                                                        <img alt="img" class="h-200 mb-2 mt-2 me-4 br-5" src="../assets/images/media/timeline1.jpg">
                                                        <img alt="img" class="h-200 br-5" src="../assets/images/media/timeline2.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="media mt-4 profile-footer align-items-center">
                                                        <div class="avatar-list avatar-list-stacked me-4">
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/8.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/7.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/9.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/14.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/11.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius bg-primary">+8</span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 text-bold text-dark-light">28 people like your photo</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border">
                                                <div class="card-header border-bottom d-block p-4">
                                                    <div class="media overflow-visible">
                                                        <div class="media-user me-2">
                                                            <div class="main-img-user"><img alt="" class="rounded-circle avatar-md" src="../assets/images/faces/6.jpg"></div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span> </div>
                                                        <div class="ms-auto">
                                                            <div class="dropdown show main-contact-star">
                                                                <a class="new option-dots2" data-bs-toggle="dropdown" href="JavaScript:void(0);"><i  class="fe fe-more-vertical  tx-18"></i></a>
                                                                <div class="dropdown-menu shadow">
                                                                    <a class="dropdown-item" href="#">Edit Post</a>
                                                                    <a class="dropdown-item" href="#">Delete Post</a>
                                                                    <a class="dropdown-item" href="#">Personal Settings</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                                    <div class="row row-sm">
                                                        <div class="col">
                                                        <img alt="img" class="h-200 mb-2 mt-2 me-4 br-5" src="../assets/images/media/timeline3.jpg">
                                                        <img alt="img" class="h-200 br-5" src="../assets/images/media/timeline4.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="media mt-4 profile-footer align-items-center">
                                                        <div class="avatar-list avatar-list-stacked me-4">
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/8.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/7.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/9.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/14.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/11.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius bg-primary">+8</span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 text-bold text-dark-light">28 people like your photo</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card border">
                                                <div class="card-header border-bottom d-block p-4">
                                                    <div class="media overflow-visible">
                                                        <div class="media-user me-2">
                                                            <div class="main-img-user"><img alt="" class="rounded-circle avatar-md" src="../assets/images/faces/6.jpg"></div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span> </div>
                                                        <div class="ms-auto">
                                                            <div class="dropdown show main-contact-star">
                                                                <a class="new option-dots2" data-bs-toggle="dropdown" href="JavaScript:void(0);"><i  class="fe fe-more-vertical  tx-18"></i></a>
                                                                <div class="dropdown-menu shadow">
                                                                    <a class="dropdown-item" href="#">Edit Post</a>
                                                                    <a class="dropdown-item" href="#">Delete Post</a>
                                                                    <a class="dropdown-item" href="#">Personal Settings</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                                    <div class="row row-sm">
                                                        <div class="col">
                                                        <img alt="img" class="h-200 mb-2 mt-2 me-4 br-5" src="../assets/images/media/timeline5.jpg">
                                                        <img alt="img" class="h-200 br-5" src="../assets/images/media/timeline6.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="media mt-4 profile-footer align-items-center">
                                                        <div class="avatar-list avatar-list-stacked me-4">
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/8.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/7.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/9.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/14.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/11.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius bg-primary">+8</span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 text-bold text-dark-light">28 people like your photo</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header border-bottom d-block p-4">
                                                    <div class="media overflow-visible">
                                                        <div class="media-user me-2">
                                                            <div class="main-img-user"><img alt="" class="rounded-circle avatar-md" src="../assets/images/faces/6.jpg"></div>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 ms-2">Mintrona Pechon Pechon</h6><span class="text-primary ms-2">just now</span> </div>
                                                        <div class="ms-auto">
                                                            <div class="dropdown show main-contact-star">
                                                                <a class="new option-dots2" data-bs-toggle="dropdown" href="JavaScript:void(0);"><i  class="fe fe-more-vertical  tx-18"></i></a>
                                                                <div class="dropdown-menu shadow">
                                                                    <a class="dropdown-item" href="#">Edit Post</a>
                                                                    <a class="dropdown-item" href="#">Delete Post</a>
                                                                    <a class="dropdown-item" href="#">Personal Settings</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p>
                                                    <div class="row row-sm">
                                                        <div class="col">
                                                        <img alt="img" class="h-200 mb-2 mt-2 me-4 br-5" src="../assets/images/media/timeline7.jpg">
                                                        <img alt="img" class="h-200 br-5" src="../assets/images/media/timeline9.jpg">
                                                        </div>
                                                    </div>
                                                    <div class="media mt-4 profile-footer align-items-center">
                                                        <div class="avatar-list avatar-list-stacked me-4">
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/8.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/7.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/9.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/14.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius cover-image" data-bs-image-src= "../assets/images/users/11.jpg"></span>
                                                            <span class="avatar avatar-md rounded-circle bradius bg-primary">+8</span>
                                                        </div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 text-bold text-dark-light">28 people like your photo</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="gallery">
                                    <div class="row  mb-5 img-gallery" id="lightgallery">
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/8.jpg" data-src="../assets/images/media/8.jpg">
                                        <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/8.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/10.jpg" data-src="../assets/images/media/10.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/10.jpg" alt="banner image "></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/11.jpg" data-src="../assets/images/media/11.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/11.jpg" alt="banner image "></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/12.jpg" data-src="../assets/images/media/12.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/12.jpg" alt="banner image "></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/13.jpg" data-src="../assets/images/media/13.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/13.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/14.jpg" data-src="../assets/images/media/14.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/14.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/15.jpg" data-src="../assets/images/media/15.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/15.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/16.jpg" data-src="../assets/images/media/16.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/16.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/17.jpg" data-src="../assets/images/media/17.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/17.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/18.jpg" data-src="../assets/images/media/18.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/18.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/19.jpg" data-src="../assets/images/media/19.jpg">
                                            <a href="#"><img class="img-fluid wp-100 mb-2 br-5" src="../assets/images/media/19.jpg " alt="banner image"></a>
                                        </div>
                                        <div class="col-lg-3 col-md-6" data-responsive="../assets/images/media/20.jpg" data-src="../assets/images/media/20.jpg">
                                            <a href="#"><img class="img-fluid wp-100 br-5" src="../assets/images/media/20.jpg " alt="banner image"></a>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="tab-pane" id="friends">
                                    <div class="row row-sm">
                                        @foreach ($userAsociados as $asociado)
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-3">
                                            <div class="card custom-card border">
                                                <div class="card-body user-lock text-center">
                                                    <div class="dropdown text-end">
                                                        <a href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="fe fe-more-vertical text-muted"></i> </a>
                                                        <div class="dropdown-menu dropdown-menu-right shadow"> <a class="dropdown-item" href="#"><i class="fe fe-message-square me-2"></i> Message</a> <a class="dropdown-item" href="#"><i class="fe fe-edit-2 me-2"></i> Edit</a> <a class="dropdown-item" href="#"><i class="fe fe-eye me-2"></i> View</a> <a class="dropdown-item" href="{{url("profile/userAsociado/{$asociado->id}")}}"><i class="fe fe-trash-2 me-2"></i> Delete</a> </div>
                                                    </div>
                                                    <a href="#">
                                                        <img alt="avatar" class="avatar avatar-xl rounded" src="{{asset("$asociado->photo")}}">
                                                        <h4 class="fs-16 mb-0 mt-3 text-dark fw-semibold">{{$asociado->name}}</h4>
                                                        <span class="text-muted">{{$asociado->identification}}</span>
                                                    </a>
                                                    <div class="footer-container-main border-0 my-2">
                                                        <div class="footer p-0 icons-bg border-0">
                                                            <div class="social">
                                                                <ul class="text-center">
                                                                    <li>
                                                                        <a class="social-icon" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="social-icon" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="social-icon" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                 {{-- Registro de Asociado --}}
                                <div class="tab-pane" id="accountSettings">
                                    <div class="card">
                                        <div class="card-body">
                                            <form method="POST" id="rgisterform" action="{{route('userAsociado.create')}}" enctype="multipart/form-data" class="form-horizontal" data-select2-id="11">
                                                <div class="mb-4 main-content-label">Account</div>
                                                @csrf
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Photo</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="photo"
                                                            accept="image/jpeg,image/jpg,image/png"
                                                            type="file"
                                                            class="form-control"
                                                            name="photo"
                                                            tabindex="1" placeholder="Enter Photo" value="{{ old('name') }}"
                                                            autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Full Name</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="firstName" type="text"
                                                            class="input100{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                            name="name"
                                                            tabindex="1" placeholder="Nombre Completo" value="{{ old('name') }}"
                                                            autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('name') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Email</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="email" type="email"
                                                            class="input100{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                            placeholder="Enter Email address" name="email" tabindex="1"
                                                            value="{{ old('email') }}"
                                                            required autofocus>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('email') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Phone</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="telefono" type="number"
                                                            class="input100{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                                            name="telefono"
                                                            tabindex="1" placeholder="Telefono" value="{{ old('telefono') }}"
                                                            autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('telefono') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Identification</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="identification"
                                                            type="number"
                                                            class="input100{{ $errors->has('identification') ? ' is-invalid' : '' }}"
                                                            name="identification"
                                                            tabindex="1" placeholder="Numero Identificacion" value="{{ old('identification') }}"
                                                            autofocus required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('identification') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Password</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="password" type="password"
                                                            class="input100{{ $errors->has('password') ? ' is-invalid': '' }}"
                                                            placeholder="Contraseña" name="password" tabindex="2" required>
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="userName" class="form-label">Password Confirmation</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input id="password_confirmation" type="password" placeholder="Confirmar Contraseña"
                                                            class="input100{{ $errors->has('password_confirmation') ? ' is-invalid': '' }}"
                                                            name="password_confirmation" tabindex="2">
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('password_confirmation') }}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                                                Register
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label for="eMail" class="form-label">Email</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="eMail" placeholder="Email" value="info@elenagilbert.in">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group " data-select2-id="108">
                                                    <div class="row" data-select2-id="107">
                                                        <div class="col-md-3">
                                                            <label for="language" class="form-label">Language</label>
                                                        </div>
                                                        <div class="col-md-9" data-select2-id="106">
                                                            <select class="form-control select2" id="language" tabindex="-1" aria-hidden="true">
                                                                <option >Us English</option>
                                                                <option >Arabic</option>
                                                                <option >Korean</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group " data-select2-id="10">
                                                    <div class="row" data-select2-id="9">
                                                        <div class="col-md-3">
                                                            <label for="timeZone" class="form-label">Timezone</label>
                                                        </div>
                                                        <div class="col-md-9" data-select2-id="8">
                                                            <select class="form-control select2" id="timeZone" data-select2-id="4" tabindex="-1" aria-hidden="true">
                                                                <option value="Pacific/Midway" data-select2-id="6">(GMT-11:00) Midway Island, Samoa</option>
                                                                <option value="America/Adak" data-select2-id="16">(GMT-10:00) Hawaii-Aleutian</option>
                                                                <option value="Etc/GMT+10" data-select2-id="17">(GMT-10:00) Hawaii</option>
                                                                <option value="Pacific/Marquesas" data-select2-id="18">(GMT-09:30) Marquesas Islands</option>
                                                                <option value="Pacific/Gambier" data-select2-id="19">(GMT-09:00) Gambier Islands</option>
                                                                <option value="America/Anchorage" data-select2-id="20">(GMT-09:00) Alaska</option>
                                                                <option value="America/Ensenada" data-select2-id="21">(GMT-08:00) Tijuana, Baja California</option>
                                                                <option value="Etc/GMT+8" data-select2-id="22">(GMT-08:00) Pitcairn Islands</option>
                                                                <option value="America/Los_Angeles" data-select2-id="23">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                                                <option value="America/Denver" data-select2-id="24">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                                                <option value="America/Chihuahua" data-select2-id="25">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                                <option value="America/Dawson_Creek" data-select2-id="26">(GMT-07:00) Arizona</option>
                                                                <option value="America/Belize" data-select2-id="27">(GMT-06:00) Saskatchewan, Central America</option>
                                                                <option value="America/Cancun" data-select2-id="28">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                                <option value="Chile/EasterIsland" data-select2-id="29">(GMT-06:00) Easter Island</option>
                                                                <option value="America/Chicago" data-select2-id="30">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                                                <option value="America/New_York" data-select2-id="31">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                                                <option value="America/Havana" data-select2-id="32">(GMT-05:00) Cuba</option>
                                                                <option value="America/Bogota" data-select2-id="33">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                                <option value="America/Caracas" data-select2-id="34">(GMT-04:30) Caracas</option>
                                                                <option value="America/Santiago" data-select2-id="35">(GMT-04:00) Santiago</option>
                                                                <option value="America/La_Paz" data-select2-id="36">(GMT-04:00) La Paz</option>
                                                                <option value="Atlantic/Stanley" data-select2-id="37">(GMT-04:00) Faukland Islands</option>
                                                                <option value="America/Campo_Grande" data-select2-id="38">(GMT-04:00) Brazil</option>
                                                                <option value="America/Goose_Bay" data-select2-id="39">(GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                                <option value="America/Glace_Bay" data-select2-id="40">(GMT-04:00) Atlantic Time (Canada)</option>
                                                                <option value="America/St_Johns" data-select2-id="41">(GMT-03:30) Newfoundland</option>
                                                                <option value="America/Araguaina" data-select2-id="42">(GMT-03:00) UTC-3</option>
                                                                <option value="America/Montevideo" data-select2-id="43">(GMT-03:00) Montevideo</option>
                                                                <option value="America/Miquelon" data-select2-id="44">(GMT-03:00) Miquelon, St. Pierre</option>
                                                                <option value="America/Godthab" data-select2-id="45">(GMT-03:00) Greenland</option>
                                                                <option value="America/Argentina/Buenos_Aires" data-select2-id="46">(GMT-03:00) Buenos Aires</option>
                                                                <option value="America/Sao_Paulo" data-select2-id="47">(GMT-03:00) Brasilia</option>
                                                                <option value="America/Noronha" data-select2-id="48">(GMT-02:00) Mid-Atlantic</option>
                                                                <option value="Atlantic/Cape_Verde" data-select2-id="49">(GMT-01:00) Cape Verde Is.</option>
                                                                <option value="Atlantic/Azores" data-select2-id="50">(GMT-01:00) Azores</option>
                                                                <option value="Europe/Belfast" data-select2-id="51">(GMT) Greenwich Mean Time : Belfast</option>
                                                                <option value="Europe/Dublin" data-select2-id="52">(GMT) Greenwich Mean Time : Dublin</option>
                                                                <option value="Europe/Lisbon" data-select2-id="53">(GMT) Greenwich Mean Time : Lisbon</option>
                                                                <option value="Europe/London" data-select2-id="54">(GMT) Greenwich Mean Time : London</option>
                                                                <option value="Africa/Abidjan" data-select2-id="55">(GMT) Monrovia, Reykjavik</option>
                                                                <option value="Europe/Amsterdam" data-select2-id="56">(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option>
                                                                <option value="Europe/Belgrade" data-select2-id="57">(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option>
                                                                <option value="Europe/Brussels" data-select2-id="58">(GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                                <option value="Africa/Algiers" data-select2-id="59">(GMT+01:00) West Central Africa</option>
                                                                <option value="Africa/Windhoek" data-select2-id="60">(GMT+01:00) Windhoek</option>
                                                                <option value="Asia/Beirut" data-select2-id="61">(GMT+02:00) Beirut</option>
                                                                <option value="Africa/Cairo" data-select2-id="62">(GMT+02:00) Cairo</option>
                                                                <option value="Asia/Gaza" data-select2-id="63">(GMT+02:00) Gaza</option>
                                                                <option value="Africa/Blantyre" data-select2-id="64">(GMT+02:00) Harare, Pretoria</option>
                                                                <option value="Asia/Jerusalem" data-select2-id="65">(GMT+02:00) Jerusalem</option>
                                                                <option value="Europe/Minsk" data-select2-id="66">(GMT+02:00) Minsk</option>
                                                                <option value="Asia/Damascus" data-select2-id="67">(GMT+02:00) Syria</option>
                                                                <option value="Europe/Moscow" data-select2-id="68">(GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                                <option value="Africa/Addis_Ababa" data-select2-id="69">(GMT+03:00) Nairobi</option>
                                                                <option value="Asia/Tehran" data-select2-id="70">(GMT+03:30) Tehran</option>
                                                                <option value="Asia/Dubai" data-select2-id="71">(GMT+04:00) Abu Dhabi, Muscat</option>
                                                                <option value="Asia/Yerevan" data-select2-id="72">(GMT+04:00) Yerevan</option>
                                                                <option value="Asia/Kabul" data-select2-id="73">(GMT+04:30) Kabul</option>
                                                                <option value="Asia/Yekaterinburg" data-select2-id="74">(GMT+05:00) Ekaterinburg</option>
                                                                <option value="Asia/Tashkent" data-select2-id="75">(GMT+05:00) Tashkent</option>
                                                                <option value="Asia/Kolkata" data-select2-id="76">(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                                <option value="Asia/Katmandu" data-select2-id="77">(GMT+05:45) Kathmandu</option>
                                                                <option value="Asia/Dhaka" data-select2-id="78">(GMT+06:00) Astana, Dhaka</option>
                                                                <option value="Asia/Novosibirsk" data-select2-id="79">(GMT+06:00) Novosibirsk</option>
                                                                <option value="Asia/Rangoon" data-select2-id="80">(GMT+06:30) Yangon (Rangoon)</option>
                                                                <option value="Asia/Bangkok" data-select2-id="81">(GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                                <option value="Asia/Krasnoyarsk" data-select2-id="82">(GMT+07:00) Krasnoyarsk</option>
                                                                <option value="Asia/Hong_Kong" data-select2-id="83">(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                                <option value="Asia/Irkutsk" data-select2-id="84">(GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                                <option value="Australia/Perth" data-select2-id="85">(GMT+08:00) Perth</option>
                                                                <option value="Australia/Eucla" data-select2-id="86">(GMT+08:45) Eucla</option>
                                                                <option value="Asia/Tokyo" data-select2-id="87">(GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                                <option value="Asia/Seoul" data-select2-id="88">(GMT+09:00) Seoul</option>
                                                                <option value="Asia/Yakutsk" data-select2-id="89">(GMT+09:00) Yakutsk</option>
                                                                <option value="Australia/Adelaide" data-select2-id="90">(GMT+09:30) Adelaide</option>
                                                                <option value="Australia/Darwin" data-select2-id="91">(GMT+09:30) Darwin</option>
                                                                <option value="Australia/Brisbane" data-select2-id="92">(GMT+10:00) Brisbane</option>
                                                                <option value="Australia/Hobart" data-select2-id="93">(GMT+10:00) Hobart</option>
                                                                <option value="Asia/Vladivostok" data-select2-id="94">(GMT+10:00) Vladivostok</option>
                                                                <option value="Australia/Lord_Howe" data-select2-id="95">(GMT+10:30) Lord Howe Island</option>
                                                                <option value="Etc/GMT-11" data-select2-id="96">(GMT+11:00) Solomon Is., New Caledonia</option>
                                                                <option value="Asia/Magadan" data-select2-id="97">(GMT+11:00) Magadan</option>
                                                                <option value="Pacific/Norfolk" data-select2-id="98">(GMT+11:30) Norfolk Island</option>
                                                                <option value="Asia/Anadyr" data-select2-id="99">(GMT+12:00) Anadyr, Kamchatka</option>
                                                                <option value="Pacific/Auckland" data-select2-id="100">(GMT+12:00) Auckland, Wellington</option>
                                                                <option value="Etc/GMT-12" data-select2-id="101">(GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                                <option value="Pacific/Chatham" data-select2-id="102">(GMT+12:45) Chatham Islands</option>
                                                                <option value="Pacific/Tongatapu" data-select2-id="103">(GMT+13:00) Nuku'alofa</option>
                                                                <option value="Pacific/Kiritimati" data-select2-id="104">(GMT+14:00) Kiritimati</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3 col">
                                                            <label class="form-label">Verification</label>
                                                        </div>
                                                        <div class="col-md-9 col d-flex">
                                                            <div class="custom-checkbox custom-control mx-2">
                                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="Email">
                                                                <label for="Email" class="custom-control-label">Email</label>
                                                            </div>
                                                            <div class="custom-checkbox custom-control mx-2">
                                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="Sms">
                                                                <label for="Sms" class="custom-control-label">Sms</label>
                                                            </div>
                                                            <div class="custom-checkbox custom-control mx-2">
                                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="Phone">
                                                                <label for="Phone" class="custom-control-label">Phone</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-4 main-content-label">Secuirity Settings</div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Login Verification</label>
                                                        </div>
                                                        <div class="col-md-9"> <a href="#">Setup Verification</a> </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row row-sm">
                                                        <div class="col-md-3">
                                                            <label class="form-label">Password Verification</label>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <div class="custom-checkbox custom-control mx-2">
                                                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="personal">
                                                                <label for="personal" class="custom-control-label">Required personal details</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="mb-4 main-content-label">Notifications</div>
                                                    <div class="form-group mb-0">
                                                        <div class="row row-sm">
                                                            <div class="col-md-3">
                                                                <label class="form-label">Configure Notifications</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <label class="d-block">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="text-muted ms-2">Allow all Notifications</span>
                                                                </label>
                                                                <label class="d-block">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input">
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="text-muted ms-2">Disable all Notifications</span>
                                                                </label>
                                                                <label class="d-block">
                                                                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" checked>
                                                                    <span class="custom-switch-indicator"></span>
                                                                    <span class="text-muted ms-2">Notification Sounds</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group float-end">
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <a class="btn btn-info my-1" href="#">Change Password</a>
                                                            <a class="btn btn-outline-danger my-1" href="#">Deactivate Account</a>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fin de registro --}}
                            </div>
                        </div><!-- COL-END -->
                    </div>
                    <!-- ROW-1 CLOSED -->
                </div>
            </div>
        </div>
        <!-- CONTAINER CLOSED -->
    </tbody>
@endsection
@section('scripts')
{{-- Registramos el usiario Asociado --}}
{{-- <script>
  $('#rgisterform').on('submit', function(e) {
    e.preventDefault(); // Para evitar que haga el submit por default
    var datosFormulario = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "{{ route('userAsociado.create') }}",
        data: datosFormulario,
        success: function(response) {
            console.log(response.data);
            if(data == "success"){
                $.notify({
                    icon: 'pe-7s-close-circle',
                    message: "Sucessfully saved the Image Sorting"
                },{
                    type: 'success',
                    timer: 500
                });
            }
            $('#formulario')[0].reset();
            $("#cargando").html(data);
        },
        error:function(error){
            console.error(error);
        }
    });
  });
</script> --}}
{{-- <script>
    function validarInput() {
    document.getElementById("btnPrEditSave").disabled = !document.getElementById("pfEmail", "pfTelefono").value.length;
    }
    $(document).on('change','input[type="file"]',function(){
        // this.files[0].size recupera el tamaño del archivo
        // alert(this.files[0].size);

        var fileName = this.files[0].name;
        var fileSize = this.files[0].size;

        if(fileSize > 300000){
            alert('El archivo no debe superar los 3MB');
            this.value = '';
            this.files[0].name = '';
        }else{
            // recuperamos la extensión del archivo
            var ext = fileName.split('.').pop();

            // Convertimos en minúscula porque
            // la extensión del archivo puede estar en mayúscula
            ext = ext.toLowerCase();

            // console.log(ext);
            switch (ext) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'pdf': break;
                default:
                    alert('El archivo no tiene la extensión adecuada');
                    this.value = ''; // reset del valor
                    this.files[0].name = '';
            }
        }
    });

</script> --}}
@if (Session::has('message'))
   <script>
       Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Usuario registrado correctamente',
        showConfirmButton: false,
        timer: 2500
        })
   </script>
@endif
@if (Session::has('messageError'))
   <script>
        Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Solo puede registrar como máximo 4 Usuario, para más información comuníquese con el Administrador!',
        })
   </script>
@endif
@endsection
