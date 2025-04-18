<?php

namespace App\DataTables;

use App\Models\Meeting;
use App\Models\Member;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MeetingDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('attendance', function ($meeting) {
                $attendance = json_decode($meeting->attendance, true);
                if ($attendance) {
                    $memberNames = Member::whereIn('id', $attendance)->pluck('name')->toArray();
                    return implode(', ', $memberNames); // Display member names as a comma-separated list
                }
                return 'No attendance';
            })
            ->addColumn('action', 'meetings.action')
            ->setRowId('id')
            ->filterColumn('group_name', function($query, $keyword) {
                $query->where('groups.name', 'like', "%{$keyword}%");
            })
            ->filterColumn('discussion', function($query, $keyword) {
                $query->where('meetings.discussion', 'like', "%{$keyword}%");
            })
            ->filterColumn('date', function($query, $keyword) {
                $query->where('meetings.date', 'like', "%{$keyword}%");
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Meeting $model): QueryBuilder
    {
        return $model->newQuery()
            ->leftJoin('groups', 'meetings.group_uid', '=', 'groups.id')
            ->select(
                'meetings.id',
                'meetings.group_uid',
                'groups.name as group_name',
                'meetings.discussion',
                'meetings.date',
                'meetings.attendance' // Include attendance field
            );
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('meeting-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
                    ->addTableClass('table table-bordered table-striped table-hover')
                    ->parameters([
                        'dom'          => ('<"top">rt<"bottom"l>Bfrtip'),
                        'buttons'      => ['export', 'print', 'reset', 'reload'],
                    ]); // Custom table styling
    }

    /**
     * Get columns.
     */
    protected function getColumns(): array
    {
        return [
            // Column::make('id'),
            Column::make('group_uid')
                ->title('Group ID'),
            Column::make('group_name')
                ->title('Group Name'),
            Column::make('discussion'),
            Column::make('attendance') // Ensure this matches the query alias
                ->title('Attendance List')
                ->exportable(true)
                ->printable(true),
            Column::make('date'),
            Column::make('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
                ->title('Actions'),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Meeting_' . date('YmdHis');
    }
}