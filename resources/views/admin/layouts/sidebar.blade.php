<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link navbar-primary text-center">
        <span class="logo-mini"><strong>{{ config('codiksh.short_name') }}</strong></span>
        <span class="brand-text font-weight-bold">{{ config('app.name') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image mt-2">
                <img style="object-fit: cover;" src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_url['100'] }}" class="img-circle elevation-2" alt="{{ \Illuminate\Support\Facades\Auth::user()->name }}'s Avatar">
            </div>
            <div class="info">
                <a href="javascript:void(0);" class="d-block">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    <br/><small style="white-space: initial">{{ \Illuminate\Support\Facades\Auth::user()->getRoleNames()->join(', ') }}</small>
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                @include('admin.layouts.menu')
            </ul>
        </nav>
    </div>
</aside>
