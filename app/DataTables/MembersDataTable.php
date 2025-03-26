<?php

namespace App\DataTables;

use App\Models\Member;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MembersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'members.action')
            ->addColumn('photo', function($member) {
                return '<img src="'.asset('storage/' . $member->photo).'" alt="Member Photo" class="w-20 h-20 object-cover rounded-full mx-auto mb-4">';
            })
            ->rawColumns(['photo', 'action'])
            ->setRowId('id')
            ->filterColumn('name', function($query, $keyword) {
                $query->where('members.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('number', function($query, $keyword) {
                $query->where('members.number', 'like', "%{$keyword}%");
            })
            ->filterColumn('village', function($query, $keyword) {
                $query->where('members.village', 'like', "%{$keyword}%");
            })
            ->filterColumn('group_name', function($query, $keyword) {
                $query->where('groups.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('caste', function($query, $keyword) {
                $query->where('members.caste', 'like', "%{$keyword}%");
            })
            ->filterColumn('share_price', function($query, $keyword) {
                $query->where('members.share_price', 'like', "%{$keyword}%");
            })
            ->filterColumn('member_type', function($query, $keyword) {
                $query->where('members.member_type', 'like', "%{$keyword}%");
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('members.status', 'like', "%{$keyword}%");
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Member $model): QueryBuilder
    {
        return $model->newQuery()
            ->leftJoin('groups', 'members.group_uid', '=', 'groups.id')
            ->select('members.id', 'members.member_uid', 'members.name', 'members.number', 'members.village', 'groups.name as group_name', 'members.caste', 'members.share_price', 'members.member_type', 'members.status'); // Added member_uid
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('members-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax() // Ensure AJAX is enabled
                    ->orderBy(1)
                    ->addTableClass('table table-bordered table-striped table-hover')
                    ->parameters([
                        'dom'          => ('<"top">rt<"bottom"l>Bfrtip'),
                        'buttons'      => ['export', 'print', 'reset', 'reload'],
                    ]); // Custom table styling
    }
                    

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('member_uid')->title('Member ID'), // Added member_uid column
            Column::make('photo'),
            Column::make('name'),
            Column::make('number'),
            Column::make('village'),
            Column::make('group_name')->title('Group'),
            Column::make('caste'),
            Column::make('share_price'),
            Column::make('member_type'),
            Column::make('status'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Members_' . date('YmdHis');
    }
}
