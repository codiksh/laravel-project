@section('css')
    @include('admin.layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table', 'id' => 'role-index']) !!}

@push('stackedScripts')
    @include('admin.layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush
