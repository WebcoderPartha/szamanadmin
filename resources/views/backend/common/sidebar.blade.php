<div class="nk-sidebar">
    <div class="nk-nav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Dashboard</li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">Home 1</a></li>
                    <!-- <li><a href="./index-2.html">Home 2</a></li> -->
                </ul>
            </li>

            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-people menu-icon"></i><span class="nav-text">Users</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('users.create') }}">Add User</a></li>
                    <li><a href="{{ route('users.index') }}">All User</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon-people menu-icon"></i><span class="nav-text">Role</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('roles.create') }}">Add Role</a></li>
                    <li><a href="{{ route('admin.permission.create') }}">Add Permission</a></li>
                    <li><a href="{{ route('roles.index') }}">All Role</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
