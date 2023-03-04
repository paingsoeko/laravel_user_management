@extends('layout/master')
@section('title', 'Users')
@section('content')
@php
   $controller = app(\App\Http\Controllers\RolesController::class);
   $rolesControl  = $controller->roleControl();
@endphp
    <main class="content">
        <div class="container-fluid p-0">
            @if(in_array(6, $rolesControl))
                <a href="{{route('users.create')}}" class="btn btn-primary float-end mt-n1"><i class="fas fa-plus"></i>
                    New User</a>
            @endif
            <div class="mb-3">
                <h1 class="h3 d-inline align-middle">Users</h1>
                <h6 class="text-muted">Manage users</h6>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">All Users</h5>
                            {{\Illuminate\Support\Facades\Auth::user()->is_active}}
                        </div>
                        <div class="card-body">
                            <table id="datatables-buttons" class="table table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user_records as $user_record)
                                    <tr>
                                        <td>{{$user_record->username}}</td>
                                        <td>{{$user_record->name}}</td>
                                        <td>
                                            {{ \App\Models\Role::find($user_record->role_id)->name }}
                                        </td>
                                        <td>{{$user_record->email}}</td>
                                        <td class="table-action">
                                            @if(\App\Models\Role::find($user_record->role_id)->name === \App\Models\Role::find(1)->name and \Illuminate\Support\Facades\Auth::user()->role_id>1)
                                                <button type="button" class="btn alert-dark btn-pill btn-sm" disabled>
                                                    <i class="align-middle me-1" data-feather="info"></i> This action
                                                    isn't allowed
                                                </button>
                                            @else
                                            @if(in_array(5, $rolesControl))
                                                <button
                                                    onclick="window.location.href='{{route('users.show',$user_record->id)}}'"
                                                    class="btn btn-pill alert-success btn-sm"><i
                                                        class="fa-solid fa-eye"></i> view
                                                </button>
                                            @endif
                                            @if(in_array(7, $rolesControl))
                                                <button
                                                    onclick="window.location.href='{{route('users.edit', $user_record->id)}}'"
                                                    class="btn btn-pill alert-warning btn-sm"><i
                                                        class="fa-solid fa-pen-to-square"></i> edit
                                                </button>
                                            @endif
                                            @if(in_array(8, $rolesControl))
                                                <form class="d-inline-block"
                                                      action="{{route('users.destroy', $user_record->id)}}"
                                                      method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-pill alert-danger btn-sm"><i
                                                            class="fa-solid fa-trash"></i> delete
                                                    </button>
                                                </form>
                                            @endif

                                            @endif
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

        <script>
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
        </script>
@endsection
