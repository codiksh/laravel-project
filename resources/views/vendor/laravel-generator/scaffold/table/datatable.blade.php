@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{ $config->namespaces->dataTables }};

use {{ $config->namespaces->model }}\{{ $config->modelNames->name }};
@if($config->options->localized)
use Yajra\DataTables\Html\Column;
@endif
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\MyClasses\GeneralHelperFunctions;

class {{ $config->modelNames->name }}DataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->editColumn('created_at', function ({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}){
                return GeneralHelperFunctions::prepareHtmlDate(${{ $config->modelNames->camel }}->created_at);
            })
            ->editColumn('updated_at', function ({{ $config->modelNames->name }} ${{ $config->modelNames->camel }}){
                return GeneralHelperFunctions::prepareHtmlDate(${{ $config->modelNames->camel }}->updated_at);
            })
            ->rawColumns(['created_at', 'updated_at', 'action'])
            ->addColumn('action', '{{ $config->modelNames->snakePlural }}.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\{{ $config->modelNames->name }} ${{ $config->modelNames->snakePlural }}
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query({{ $config->modelNames->name }} ${{ $config->modelNames->snakePlural }})
    {
        return ${{ $config->modelNames->snakePlural }}->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'B<\'row p-t-15\' <\'col-sm-6\'l><\'col-sm-6\'f>>rt<\'row\'<\'col-sm-12 col-md-5\'i><\'col-sm-12 col-md-7\'p>>',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'colvis', 'className' => 'btn btn-default btn-sm no-corner']
            ],
@if($config->options->localized)
                'language' => [
                    'url' => url('//cdn.datatables.net/plug-ins/1.10.12/i18n/English.json'),
                ],
@endif
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            {!! $columns !!},
            'created_at' => ['title' => 'Added on'],
            'updated_at' => ['title' => 'Updated on'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return '{{ $config->modelNames->snakePlural }}_datatable_' . time();
    }
}
