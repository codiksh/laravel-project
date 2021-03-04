<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.wiki.index') }}">
                Wiki
            </a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                Hi, {{Auth::user()->name}} <i class="fas fa-caret-down"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('profile') }}" class="dropdown-item">
                    <i class="fas fa-user-edit"></i> Manage Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile.emailSignature.index') }}" class="dropdown-item">
                    <i class="fas fa-file-signature mr-2"></i> Manage Email Signature
                </a>
                <a href="{{ route('password.change') }}" class="dropdown-item">
                    <i class="fas fa-lock mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.logout') }}" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Log out
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
