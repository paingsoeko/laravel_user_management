@extends('layout/master')
@section('title', 'Users')
@section('content')
@php
    $controller = app(\App\Http\Controllers\RolesController::class);
    $rolesControl  = $controller->roleControl();
@endphp
<main class="content">
    <div class="container-fluid p-0">
        @if(in_array(2, $rolesControl))
            <a href="{{route('roles.create')}}" class="btn btn-primary float-end mt-n1"><i class="fas fa-plus"></i>
                New Role</a>
        @endif
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Roles</h1>
            <h6 class="text-muted">Manage roles</h6>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">All users</h5>
                    </div>
                    <div class="card-body">
                        <table id="datatables-buttons" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th>Roles</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role_records as $role_record)
                                <tr>
                                    <td>{{$role_record->name}}</td>
                                    <td class="table-action">
                                        @if(($role_record->name === \App\Models\Role::find(1)->name and \Illuminate\Support\Facades\Auth::user()->role_id>1) or (!in_array(3, $rolesControl) and !in_array(4, $rolesControl)))
                                            <button type="button" class="btn alert-dark btn-pill btn-sm" disabled>
                                                <i class="align-middle me-1" data-feather="info"></i> This action
                                                isn't allowed
                                            </button>
                                        @else
                                            @if(in_array(3, $rolesControl))
                                                <button
                                                    onclick="window.location.href='{{route('roles.edit', $role_record->id)}}'"
                                                    class="btn btn-pill alert-warning btn-sm ml-2"><i
                                                        class="fa-solid fa-pen-to-square"></i> edit
                                                </button>
                                            @endif
                                            @if(in_array(4, $rolesControl))
                                                <form class="d-inline-block"
                                                      action="{{route('roles.destroy', $role_record->id)}}"
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
</main>

{{-- warning message modal start--}}
<div class="modal fade show" id="messageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-center w-100" id="myModalLabel">Delete Role</h4>
            </div>
            <div class="modal-body">
                <div class="p-2 alert-danger rounded-2">
                    <strong>Note</strong><span class="ms-2">that the following role cannot be deleted:</span>
                </div>
                <p class="text-black-75 mt-3"> {{\Session::get('warning-message')}} </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>
{{-- warning message modal end--}}

<script>
    @if(\Session::has('warning-message'))
    $(document).ready(function () {
        $('#messageModal').modal('show');
    });
    @endif
</script>


@endsection
