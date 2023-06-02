@@extends('admin.layouts.master')

@@section('title')
    Create {{ $config->modelNames->human }} - {{ config('app.name') }}
@@endsection

@@section('page_headers')
    <h3><i class="fa-duotone fa-users mr-2"></i>{{ $config->modelNames->humanPlural }}</h3>
@@endsection

@@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">{{ $config->modelNames->humanPlural }}</a></li>
    <li class="breadcrumb-item active">Create</li>
@@endsection


@@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            @@include('adminlte-templates::common.errors')
                            @{!! Form::open(['route' => '{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.store',  'files' => true, 'class' => 'submitsByAjax']) !!}
                            <div class="row">
                                @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.fields', ['type' => 'create'])
                            </div>
                            @{!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@@endsection
