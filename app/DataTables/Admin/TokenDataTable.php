<?php

namespace App\DataTables\Admin;

use Carbon\Carbon;
use Laravel\Sanctum\PersonalAccessToken;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class TokenDataTable extends DataTable
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
            ->editColumn('last_used_at', function (PersonalAccessToken $personalAccessToken){
                return Carbon::createFromFormat('Y-m-d H:i:s',$personalAccessToken->created_at)->toDayDateTimeString();
            })
            ->editColumn('created_at', function (PersonalAccessToken $personalAccessToken){
                return Carbon::createFromFormat('Y-m-d H:i:s',$personalAccessToken->created_at)->toDayDateTimeString();
            })
            ->editColumn('updated_at', function (PersonalAccessToken $personalAccessToken){
                return Carbon::createFromFormat('Y-m-d H:i:s',$personalAccessToken->updated_at)->toDayDateTimeString();
            })

            ->addColumn('action', function (PersonalAccessToken $personalAccessToken) {
                return View('admin.tokens.datatables_actions', ['PersonalAccessToken' => $personalAccessToken])->render();
            })
            ->rawColumns(['action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param PersonalAccessToken $model
     * @return mixed
     */
    public function query(PersonalAccessToken $model)
    {
        return $model->newQuery();
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
                'responsive'=> true,
                'dom'       => 'RB<\'row pt-15\' <\'col-sm-6\'l><\'col-sm-6\'f>>rt<\'row\'<\'col-sm-12 col-md-5\'i><\'col-sm-12 col-md-7\'p>>',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
//                    ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
//                    ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'colvis', 'className' => 'btn btn-default btn-sm no-corner']
                ],
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
            'name',
            'last_used_at' => ['title' => 'last used on'],
            'created_at' => ['title' => 'Added on'],
            'updated_at' => ['title' => 'Updated on'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() : string
    {
        return 'tokendatatable_' . time();
    }
}
