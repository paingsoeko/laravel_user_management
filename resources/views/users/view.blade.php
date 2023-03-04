@extends('layout/master')
@section('title', 'Users')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <a href="{{route('users.index')}}" class="btn btn-primary float-end mt-n1"><i class="fas fa-arrow-left"></i> Back</a>
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">User view</h1>
        </div>

        <div class="row">
            <div class="col-md-3 col-xl-2">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Profile Settings</h5>
                    </div>

                    <div class="list-group list-group-flush" role="tablist">
                        <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#userinfo" role="tab">
                            User Information
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#document" role="tab">
                            Documents & Note
                        </a>
                        <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#activities" role="tab">
                            Activities
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-xl-10">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="userinfo" role="tabpanel">
                        <div class="card">
                            <div class="card-header">

                                <h5 class="card-title mb-0">User Information</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Name:</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p>{{$user->name}}</p>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Username:</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p>{{$user->username}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Gender:</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            @switch($user->gender)
                                                @case(1)
                                                    Male
                                                @break
                                                @case(2)
                                                    Female
                                                @break
                                                @case(3)
                                                    Rather not say
                                                @break
                                            @endswitch
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Role:</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <p>{{$role_name}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Email:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$user->email}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Phone:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <p>{{$user->phone}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <h4>Account Status:</h4>
                                    </div>
                                    <div class="col-md-6">
                                        @if($user->is_active === 1)
                                            <p class="text-success">active</p>
                                        @else
                                            <p class="text-danger">deactivate</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="document" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Documents & Note</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, voluptates nostrum? Accusamus, ab? Quisquam dolor ipsum consectetur! Ipsum corrupti sit ea? Delectus ab tempore fugit dolor iure molestiae corrupti cum facilis at officia blanditiis voluptas eius ullam, facere consequatur repudiandae perspiciatis quisquam excepturi obcaecati. Iure earum eum inventore, tenetur sed nesciunt assumenda ipsa beatae officia magni, accusamus voluptatem id? Harum tenetur aspernatur voluptate dolorem excepturi? Voluptatum ipsum assumenda aut illo, saepe quas unde non, ea voluptate eligendi atque! Animi facilis assumenda cupiditate qui corporis esse beatae, atque consequuntur cum. Dolorum doloremque maiores reprehenderit ipsa ducimus animi provident fugit odio unde.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="activities" role="tabpanel">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Activities</h5>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium, voluptates nostrum? Accusamus, ab? Quisquam dolor ipsum consectetur! Ipsum corrupti sit ea? Delectus ab tempore fugit dolor iure molestiae corrupti cum facilis at officia blanditiis voluptas eius ullam, facere consequatur repudiandae perspiciatis quisquam excepturi obcaecati. Iure earum eum inventore, tenetur sed nesciunt assumenda ipsa beatae officia magni, accusamus voluptatem id? Harum tenetur aspernatur voluptate dolorem excepturi? Voluptatum ipsum assumenda aut illo, saepe quas unde non, ea voluptate eligendi atque! Animi facilis assumenda cupiditate qui corporis esse beatae, atque consequuntur cum. Dolorum doloremque maiores reprehenderit ipsa ducimus animi provident fugit odio unde.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
