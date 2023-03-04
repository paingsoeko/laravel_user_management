@php use Illuminate\Support\Facades\Auth;@endphp
@extends('layout/master')
@section('title', 'Users')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">My Profile</h1>
            <div class="row">
                <div class="col-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="account" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 col-xl-3">
                                    <div class="card mb-3">
                                        <div class="card-body text-center">
                                            <a class="nav-icon pe-md-0 dropdown-toggle p-0 d-inline-block" href="#"
                                               data-bs-toggle="dropdown">
                                                <img img
                                                     src="{{app('\App\Http\Controllers\UsersController')->profileUrl()}}"
                                                     alt="Example Image"
                                                     class="img-fluid mb-2 mt-2" alt="{{Auth::user()->name}}"
                                                     style="width: 180px; height: 180px; border-radius: 10px;">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-dark">
                                                <a href="#" class="dropdown-item" data-bs-toggle="modal"
                                                   data-bs-target="#profileUploadModal">
                                                    <i class="fa-solid fa-pen-to-square fa-fw"></i> Edit Profile
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <form class="d-inline-block"
                                                      action="{{ route('user.profile.destroy', Auth::user()->id) }}"
                                                      method="post">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i class="fa-solid fa-trash fa-fw"></i> Remove Profile</button>
                                                </form>
                                            </div>
                                            <h2 class="mb-1">{{Auth::user()->name}}</h2>
                                            <div
                                                class="text-muted mb-2">{{\App\Models\Role::find(Auth::user()->role_id)->name}}</div>
                                        </div>
                                        <hr class="my-0">
                                        <div class="card-body">
                                            <h5 class="h6 card-title mb-3">Contact</h5>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-1"><i class="fa-solid fa-envelope fa-fw me-1"></i> Email
                                                    <a href="#">{{Auth::user()->email}}</a></li>
                                                <li class="mb-1"><i class="fa-solid fa-phone fa-fw me-1"></i> Phone <a
                                                        href="#">{{Auth::user()->phone}}</a></li>
                                                <li class="mb-1"><i class="fa-solid fa-location-dot fa-fw me-1"></i>
                                                    Address <a href="#">Yangon</a></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-xl-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Public info</h5>
                                        </div>

                                        <div class="card-body">
                                            <form method="post" action="{{route('user.password.update')}}">
                                                @csrf
                                                @method('put')
                                                <div class="mb-3">
                                                    <label class="form-label" for="inputPasswordCurrent">Current
                                                        password</label>
                                                    <input id="inputPasswordCurrent" type="password"
                                                           class="form-control @error('current_password') is-invalid @enderror"
                                                           name="current_password" autocomplete="current-password">
                                                    @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">New Password</label>
                                                    <input id="password" type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           name="password" autocomplete="current-password">
                                                    @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Confirm Password</label>
                                                    <input id="password" type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           name="password_confirmation"
                                                           autocomplete="current-password">
                                                    @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <button type="submit" name="pwd_change" class="btn btn-primary">Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>



    {{-- profile upload modal start--}}
    <div class="modal fade show" id="profileUploadModal" data-bs-backdrop="static" data-bs-keyboard="false"
         tabindex="-1"
         role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center w-100" id="myModalLabel">Edit Profile Picture</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('user.photo.upload')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-0">
                            <input class="form-control form-control-lg mb-4" id="photo" type="file" name="photo"
                                   accept="image/*">
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text">To</span>
                            <select class="form-select form-control-lg" name="storage" id="storage">
                                <option selected value="default">Default Storage</option>
                                <option value="cloud_space">Cloud Space</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="#" type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Dismiss</a>
                            <button type="submit" class="btn btn-primary  mb-0"><i
                                    class="fas fa-upload"></i> Upload
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    {{-- profile upload modal end--}}

@endsection
