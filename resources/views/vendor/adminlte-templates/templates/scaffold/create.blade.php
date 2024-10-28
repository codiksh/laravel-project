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
                            @{!! html()->form('POST', route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.store'))->open() !!}
                                <div class="card-body">
                                    <div class="row">
                                        @@include('{{ $config->prefixes->getViewPrefixForInclude() }}{{ $config->modelNames->snakePlural }}.fields')
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @{!! html()->submit('Save')->class('btn btn-primary') !!}
                                    <a href="@{{ route('{!! $config->prefixes->getRoutePrefixWith('.') !!}{!! $config->modelNames->camelPlural !!}.index') }}" class="btn btn-default">@if($config->options->localized) @@lang('crud.cancel') @else Cancel @endif</a>
                                </div>
                            @{!! html()->form()->close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@@endsection
