@php
    use Illuminate\Support\Facades\Auth;

    $controller = app(\App\Http\Controllers\RolesController::class);
    $rolesControl  = $controller->roleControl();
@endphp
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}">
			<span class="sidebar-brand-text align-middle">
			</span>
            <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewbox="0 0 24 24" fill="none"
                 stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF"
                 style="margin-left: -3px">
                <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                <path d="M20 12L12 16L4 12"></path>
                <path d="M20 16L12 20L4 16"></path>
            </svg>
        </a>
        <div class="sidebar-user">
            <div class="d-flex justify-content-center">
                <div class="flex-shrink-0">
                    <img
                        src="{{app('\App\Http\Controllers\UsersController')->profileUrl()}}"
                        class="avatar img-fluid rounded me-1" alt="Charles Hall">
                </div>
                <div class="flex-grow-1 ps-2">
                    <a class="sidebar-user-title dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        {{Auth::user()->name}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-start">
                        <a class="dropdown-item" href="{{route('user.profile')}}"><i class="align-middle me-1"
                                                                                     data-feather="user"></i>
                            Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Log out</a>
                    </div>

                    <div class="sidebar-user-subtitle">{{ \App\Models\Role::find(Auth::user()->role_id)->name }}</div>
                </div>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Home
            </li>
            <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{route('home')}}">
                    <i class="align-middle" data-feather="pie-chart"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>
            <li class="sidebar-header">
                Settings
            </li>
            <li class="sidebar-item {{ (request()->is('users') or request()->is('roles')) ? 'active' : '' }}">
                <a data-bs-target="#ui" data-bs-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">User Management</span>
                </a>
                <ul id="ui"
                    class="sidebar-dropdown list-unstyled collapse {{(request()->is('users') or request()->is('roles')) ? 'show' : ''}}"
                    data-bs-parent="#sidebar">
                    @if(in_array(5, $rolesControl))
                        <li class="sidebar-item {{request()->is('users') ? 'active' : ''}}"><a class="sidebar-link"
                                                                                               href="{{route('users.index')}}">Users</a>
                        </li>
                    @endif
                    @if(in_array(1, $rolesControl))
                        <li class="sidebar-item {{request()->is('roles') ? 'active' : ''}}"><a class="sidebar-link"
                                                                                               href="{{route('roles.index')}}">Roles</a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>
