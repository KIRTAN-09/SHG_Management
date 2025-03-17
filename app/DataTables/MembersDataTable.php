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
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Member $model): QueryBuilder
    {
        return $model->newQuery()
            ->leftJoin('groups', 'members.group_id', '=', 'groups.id')
            ->select('members.id', 'members.name', 'members.number', 'members.village', 'groups.name as group_name', 'members.caste', 'members.share_price', 'members.member_type', 'members.status'); // Corrected select statement
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
                    ->selectStyleSingle()
                    // ->dom('<"top"f>rt<"bottom"lp><"clear">Bfrtip') // Custom DOM layout
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    ->addTableClass('table table-bordered table-striped table-hover'); // Custom table styling
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::make('id'),
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
