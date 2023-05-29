<aside class="main-sidebar elevation-4 sidebar-dark-primary ">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('icon.jpg') }}" alt="{{ config('app.name') }}'s logo"
             class="brand-image img-circle elevation-3" style="">
        <h4 class="brand-text">{{ config('app.name') }}</h4>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image" style="display: flex; align-items: center">
                <img src="{{ \Illuminate\Support\Facades\Auth::user()->avatar_url['100'] }}"
                     class="img-circle elevation-2" alt="{{ \Illuminate\Support\Facades\Auth::user()->name }}'s Avatar">
            </div>
            <div class="info">
                <a href="#" class="text-light">
                    <strong>{{ \Illuminate\Support\Facades\Auth::user()->name }}</strong>
                    <br/><small class="user-role"
                                style="white-space: initial">{{ \Illuminate\Support\Facades\Auth::user()->getRoleNames()->join(', ') }}</small>
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu"
                data-accordion="false">
                @include('admin.layouts.adminlte.menu')
            </ul>
        </nav>
    </div>
</aside>
