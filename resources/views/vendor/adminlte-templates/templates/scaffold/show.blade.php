@@extends('admin.layouts.master')

@@section('title')
    View {{ $config->modelNames->human }} - {{ config('app.name') }}
@@endsection

@@section('page_headers')
    <h3><i class="fa-duotone fa-users mr-2"></i>{{ $config->modelNames->humanPlural }}</h3>
@@endsection

@@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}">{{ $config->modelNames->humanPlural }}</a></li>
    <li class="breadcrumb-item active">View</li>
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


                        <div class="card-header">
                            <div class="w-100 d-flex justify-content-between ">
                                <div class="d-flex align-items-center">
                                    <h4>@{!! ${{ $config->modelNames->camel }}->name !!}</h4>
                                </div>
                                <div class="d-flex align-items-center action_button">
                                    @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.datatables_actions', ['uuid' => ${{ $config->modelNames->camel }}->{{ $config->primaryName }}])
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="show{{ $config->modelNames->camel }}">
                                @{!! Form::model(${{ $config->modelNames->camel }}, ['route' => ['{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.update', ${{ $config->modelNames->camel }}->{{ $config->primaryName }}], 'method' => 'patch',  'files' => true, 'class' => 'submitsByAjax']) !!}
                                <div class="row">
                                    @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.fields', ['type' => 'edit'])
                                </div>
                                @{!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@@endsection


@@push('stackedScripts')
    <script>
        disableInputsForView($('#show{{ $config->modelNames->camel }}'));
    </script>
@@endpush
