<?php

namespace App\DataTables;

use App\Models\IGA; // Change to IGA model
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IgasDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $dataTable = new EloquentDataTable($query->with('member'));

        return $dataTable->addColumn('Total earned', function ($row) {
            return $row->earned1 + $row->earned2 + $row->earned3; // Calculate total earned in the backend
        })->addColumn('action', function($row) {
            return view('igas.action', compact('row'))->render();
        });
    }

    public function query(IGA $model): QueryBuilder // Change to IGA model
    {
        return $model->newQuery()->with('member'); // Include member relationship
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('igas-table')
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
            Column::make('id'),
            Column::make('member_uid')
                ->title('Member UID')
                ->data('member.member_uid'), // Explicitly map to the correct field in the member table
            Column::make('name')
                ->data('member.name'), // Map to member's name field
            Column::make('category1'),
            Column::make('earned1'),
            Column::make('category2'),
            Column::make('earned2'),
            Column::make('category3'), 
            Column::make('earned3'),
            Column::make('date'), 
            Column::make('Total earned')
                ->data('Total earned') // Reference the computed backend column
                ->title('Total Earned'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'Igas_' . date('YmdHis');
    }
}