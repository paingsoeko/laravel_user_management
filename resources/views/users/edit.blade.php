@extends('layout/master')
@section('title', 'Users')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <a href="{{route('users.index')}}" class="btn btn-primary float-end mt-n1"><i class="fas fa-arrow-left"></i> Back</a>
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Add user</h1>
            </div>
            <form method="post" action="{{route('users.update', $user->id)}}">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Basic Info</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 ">
                                    <div class="col-md-2">
                                        <label for="prefix" class="form-label">Prefix:</label>
                                        <select class="form-select" name="prefix" id="prefix">
                                            <option selected="" disabled="" value="">Choose...</option>
                                            <option {{Str::startsWith($user->name, 'Mr') ? 'selected' : ''}} value="Mr">Mr</option>
                                            <option {{Str::startsWith($user->name, 'Mrs') ? 'selected' : ''}} value="Mrs">Mrs</option>
                                            <option {{Str::startsWith($user->name, 'Miss') ? 'selected' : ''}} value="Miss">Miss</option>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="firstName" class="form-label">First Name:*</label>
                                        <input type="text" value="@if(Str::startsWith($user->name, 'Mrs ')){{Str::replace('Mrs ', '',$user->name)}} @elseif(Str::startsWith($user->name, 'Miss ')){{Str::replace('Miss ', '',$user->name)}} @elseif(Str::startsWith($user->name, 'Mr ')){{Str::replace('Mr ', '',$user->name)}}@else{{$user->name}}@endif" name="firstName" class="form-control @error('firstName') is-invalid @enderror" id="firstName" placeholder="First Name" autofocus>
                                        @if ($errors->has('firstName'))
                                            <div class="invalid-feedback">{{ $errors->first('firstName') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-md-5">
                                        <label for="lastName" class="form-label">Last Name:</label>
                                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="gender" class="form-label">Gender:</label>
                                        <select class="form-select" name="gender" id="role">
                                            <option selected="" disabled="" value="">Choose...</option>
                                            <option {{$user->gender==1 ? 'selected' : ''}} value="1">Male</option>
                                            <option {{$user->gender==2 ? 'selected' : ''}} value="2">Female</option>
                                            <option {{$user->gender==3 ? 'selected' : ''}} value="3">Rather not say</option>
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Email Address</label>
                                        <input type="text" value="{{$user->email}}" name="email" class="form-control" data-inputmask="'alias': 'email'">
                                    </div>
                                    <div class="col-md-5">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" value="{{$user->phone}}" name="phone" class="form-control" id="phone" placeholder="Start with 09">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check form-switch mt-4 pt-3">
                                            <input class="form-check-input" name="is_active" type="checkbox" id="flexSwitchCheckChecked" {{$user->is_active==1 ? 'checked' : ''}}>
                                            <label class="form-check-label" for="flexSwitchCheckChecked">Is active ?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Roles and Permissions</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username:*</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="inputUser">@</span>
                                            <input type="text" value="{{$user->username}}" name="username" class="form-control @error('username') is-invalid @enderror" id="username" aria-describedby="inputUser">
                                            @if ($errors->has('username'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('username') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Password:*</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Confirm Password:*</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" autocomplete="current-password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label for="role" class="form-label">Role:*</label>
                                        <select class="form-select @error('role_id') is-invalid @enderror" name="role_id" id="role">
                                            <option selected="" disabled="" value="">Choose...</option>

                                            @foreach($role_records as $role_record)
                                                <option {{$user->role_id === $role_record->id ? 'selected' : ''}} @if($role_record->name == "SystemAdministrator" and \Illuminate\Support\Facades\Auth::user()->role_id>1) disabled @endif value="{{$role_record->id}}">{{$role_record->name}}</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('role_id'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('role_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-lg" type="submit">Update User Account</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </main>
@endsection
