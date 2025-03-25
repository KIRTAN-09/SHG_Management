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
        $dataTable = new EloquentDataTable($query);
        return $dataTable->addColumn('action', function($row) {
            return view('igas.action', compact('row'))->render();
        });
    }

    public function query(IGA $model): QueryBuilder // Change to IGA model
    {
        return $model->newQuery();
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
            Column::make('name'),
            Column::make('category'), // Change to category
            Column::make('date'), // Change to date
            Column::make('earned'), // Change to earned
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