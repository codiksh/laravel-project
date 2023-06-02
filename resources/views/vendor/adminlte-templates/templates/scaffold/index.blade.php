@@extends('admin.layouts.master')

@@section('title')
    {{ $config->modelNames->humanPlural }} - {{ config('app.name') }}
@@endsection

@@section('page_headers')
    <h3><i class="fa-duotone fa-users mr-2"></i>{{ $config->modelNames->humanPlural }}</h3>
@@endsection

@@section('breadcrumbs')
    <li class="breadcrumb-item active">{{ $config->modelNames->humanPlural }}</li>
@@endsection

@@section('page_buttons')
    <a class="btn btn-primary" href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.create') }}"><i class="fa-solid fa-plus"></i> Add {{ $config->modelNames->humanPlural }}</a>
@@endsection

@@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            @@include('flash::message')
                            {!! $table !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@@endsection
