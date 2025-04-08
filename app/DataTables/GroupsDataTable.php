<?php

namespace App\DataTables;

use App\Models\Group;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class GroupsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('president_name', function($row) {
                return $row->members->where('member_type', 'President')->first()->name ?? 'N/A';
            })
            ->addColumn('secretary_name', function($row) {
                return $row->members->where('member_type', 'Secretary')->first()->name ?? 'N/A';
            })
            ->addColumn('no_of_members', function($row) {
                return $row->members->count();
            })
            ->addColumn('Revolving_Fund', function ($group) {
                return $group->Revolving_Fund ?? 'null';
            })
            ->addColumn('action', function($row) {
                return view('groups.action', ['id' => $row->id]);
            })
            ->rawColumns(['fund_received']);
    }

    public function query(Group $model): QueryBuilder
    {
        return $model->newQuery()->with('members');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('groups-table')
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
            Column::make('village_name'),
            column::make('group_uid'),
            Column::make('president_name')->title('President'),
            Column::make('secretary_name')->title('Secretary'),
            Column::make('no_of_members')->title('No. of Members'),
            Column::make('Revolving_fund')->title('Revolving Fund'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Groups_' . date('YmdHis');
    }
}