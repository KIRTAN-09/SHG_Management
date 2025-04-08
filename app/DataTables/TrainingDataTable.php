<?php

namespace App\DataTables;

use App\Models\Training;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TrainingDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('members_name', function ($row) {
                return $row->member->name ?? 'N/A'; // Fetch member name dynamically
            })
            ->addColumn('members_ID', function ($row) {
                return $row->member->member_uid ?? 'N/A'; // Fetch member ID dynamically
            })
            ->addColumn('action', 'training.action');
    }

    public function query(Training $model): QueryBuilder
    {
        return $model->newQuery()->with('member')->select('trainings.*'); // Ensure 'member' relationship is loaded
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('training-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
                    ->addTableClass('table table-bordered table-striped table-hover')
                    ->parameters([
                        'dom'          => ('<"top">rt<"bottom"l>Bfrtip'),
                        'buttons'      => ['export', 'print', 'reset', 'reload'],
                    ]); // Custom table styling 
    }

    protected function getColumns(): array
    {
        return [
            // Column::make('id'),
            Column::make('training_date'),
            Column::make('trainer'),
            Column::make('members_name'),
            Column::make('members_ID'),
            Column::make('location'),
            Column::make('category'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Training_' . date('YmdHis');
    }
}