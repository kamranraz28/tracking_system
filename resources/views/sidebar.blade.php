<nav class="pcoded-navbar" style="background-color: {{ $sidebarColor }};">
    <div class="navbar-wrapper" >
        <div class="navbar-content scroll-div">
            <div class="">
                <div class="main-menu-header" style="background-color: {{ $sidebarColor }};">
                    @if (Auth::user()->image !== null)
                        <img class="img-fluid rounded-circle" src="{{ asset('storage/img/' . Auth::user()->image) }}"
                            alt="User-Profile-Image" style="width: 40px; height: 40px;">
                    @else
                        <img class="img-fluid rounded-circle" src="{{ asset('assets/images/user/avatar-2.jpg') }}"
                            alt="User-Profile-Image" style="width: 40px; height: 40px;">
                    @endif

                    <div class="user-details" >
                        <span>{{ Auth::user()->name }}</span>
                        <div id="more-details">
                            @if (Auth::user()->getRoleNames()->isNotEmpty())
                                {{ Auth::user()->getRoleNames()->implode(', ') }}
                            @else
                                No Role Assigned
                            @endif
                            <i class="fa fa-chevron-down m-l-5"></i>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="nav-user-link">
                    <ul class="list-unstyled">
                        <li class="list-group-item"><a href="{{ route('viewProfie') }}"><i
                                    class="feather icon-user m-r-5"></i>View Profile</a></li>
                        <li class="list-group-item"><a href="{{ route('userLogout') }}"><i
                                    class="feather icon-log-out m-r-5"></i>Logout</a></li>
                    </ul>
                </div>
            </div>

            <ul class="nav pcoded-inner-navbar">
                <li class="nav-item pcoded-menu-caption">
                    <label>Navigation</label>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.dashboard') }}" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
                @can('software_settings')
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-settings"></i></span>
                        <span class="pcoded-mtext">Software Settings</span>
                    </a>
                    <ul class="pcoded-submenu" style="background-color: {{ $sidebarColor }};">
                        <li><a href="{{ route('logoChangeView') }}">Application Logo</a></li>
                        <li><a href="{{ route('colorChangeView') }}">Application Color</a></li>

                    </ul>
                </li>
                @endcan
                @can('user_configuration')
                <li class="nav-item pcoded-hasmenu">
                    <a href="#!" class="nav-link">
                        <span class="pcoded-micon"><i class="feather icon-layout"></i></span>
                        <span class="pcoded-mtext">User Configuration</span>
                    </a>
                    <ul class="pcoded-submenu" style="background-color: {{ $sidebarColor }};">
                        <li><a href="{{ route('permissions.index') }}">Permissions</a></li>
                        <li><a href="{{ route('roles.index') }}">Roles</a></li>
                        <li><a href="{{ route('users.index') }}">Users</a></li>
                    </ul>
                </li>
                @endcan
            </ul>
        </div>
    </div>
</nav>