@extends('layout/master')
@section('title', 'Users')
@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <a href="{{route('roles.index')}}" class="btn btn-primary float-end mt-n1"><i class="fas fa-arrow-left"></i> Back</a>
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Edit Role</h1>
        </div>
        <form method="post" action="{{route('roles.update', $roles->id)}}">
            @csrf
            @method('put')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-3 ">
                                <div class="row g-3">
                                    <div class="col-md-5">
                                        <label for="role" class="form-label">Role Name:</label>
                                        <input type="text" name="name" class="form-control" id="role" value="{{$roles->name}}" placeholder="Role Name" required>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label>Permissions:</label>
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-1">
                                        <h4>Other</h4>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-check">
                                            <input {{in_array(9, $role_permissions) ? 'checked' : ''}} class="form-check-input" name="viewButtons" type="checkbox" value="9">
                                            <span class="form-check-label">
														View export to buttons (csv/excel/print/pdf) on tables
													</span>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-md-1">
                                        <h4>User</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-check">
                                            <input class="form-check-input" type="checkbox" id="select-all-1">
                                            <span class="form-check-label">
														Select All
													</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-check">
                                            <input {{in_array(5, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-1" name="viewUser" type="checkbox" value="5">
                                            <span class="form-check-label">
														View user
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(6, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-1" name="addUser" type="checkbox" value="6">
                                            <span class="form-check-label">
														Add user
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(7, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-1" name="editUser" type="checkbox" value="7">
                                            <span class="form-check-label">
														Edit user
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(8, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-1" name="deleteUser" type="checkbox" value="8">
                                            <span class="form-check-label">
														Delete user
													</span>
                                        </label>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-md-1">
                                        <h4>Role</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-check">
                                            <input class="form-check-input checkAll" type="checkbox" id="select-all-2">
                                            <span class="form-check-label">
														Select All
													</span>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <label class="form-check">
                                            <input {{in_array(1, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-2" name="viewRole" type="checkbox" value="1">
                                            <span class="form-check-label">
														View role
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(2, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-2" name="addRole" type="checkbox" value="2">
                                            <span class="form-check-label">
														Add role
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(3, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-2" name="editRole" type="checkbox" value="3">
                                            <span class="form-check-label">
														Edit role
													</span>
                                        </label>
                                        <label class="form-check">
                                            <input {{in_array(4, $role_permissions) ? 'checked' : ''}} class="form-check-input checkbox-group-2" name="deleteRole" type="checkbox" value="4">
                                            <span class="form-check-label">
														Delete role
													</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-primary btn-lg" name="edit_role" type="submit">Update</button>
                </div>
            </div>
        </form>

    </div>
</main>
<script>
    for (let i = 1; i <= 5; i++) {
        document.getElementById(`select-all-${i}`).addEventListener('click', function() {
            const checkboxes = document.querySelectorAll(`.checkbox-group-${i}`);
            for (let j = 0; j < checkboxes.length; j++) {
                checkboxes[j].checked = this.checked;
            }
        });
    }
</script>
@endsection
