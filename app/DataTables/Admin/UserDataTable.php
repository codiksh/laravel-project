<?php

namespace App\DataTables\Admin;

use App\Models\User;
use App\MyClasses\GeneralHelperFunctions;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
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
            ->addColumn('avatar', function(User $query){
                $content = "<div class='text-center'><img src={$query->avatarUrl['100']} alt=\"{$query->name}'s Message\" width='90'/></div>";
                return $content;
            },0)
            ->addColumn('roles', function(User $user){
                return implode(', ', $user->getRoleNames()->toArray());
            })
            ->editColumn('email_verified_at', function (User $user){
                return !is_null($user->email_verified_at) ? Carbon::createFromFormat('Y-m-d H:i:s',$user->email_verified_at)->toDayDateTimeString() ?? '' : '';
            })
            ->editColumn('created_at', function (User $user){
                return GeneralHelperFunctions::prepareHtmlDate($user->created_at);
            })
            ->editColumn('updated_at', function (User $user){
                return GeneralHelperFunctions::prepareHtmlDate($user->updated_at);
            })

            ->addColumn('action', 'admin.users.datatables_actions')
            ->rawColumns(['avatar','action', 'created_at', 'updated_at']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                'dom'       => 'B<\'row pt-15\' <\'col-sm-6\'l><\'col-sm-6\'f>>rt<\'row\'<\'col-sm-12 col-md-5\'i><\'col-sm-12 col-md-7\'p>>',
                'stateSave' => true,
                'order'     => [[count($this->getColumns()) -1 , 'desc']],
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
            'avatar',
            'name',
            'email',
            'mobile',
            'roles',
            'email_verified_at' => ['title' => 'Email verified on'],
            'created_at' => ['title' => 'Added on'],
            'updated_at' => ['title' => 'Updated on'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'usersdatatable_' . time();
    }
}
