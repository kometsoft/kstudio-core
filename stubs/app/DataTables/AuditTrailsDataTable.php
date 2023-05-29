<?php

namespace App\DataTables;

use Spatie\Activitylog\Models\Activity as AuditTrail;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class AuditTrailsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(config('app.date_format_human')) ?: null;
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AuditTrail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AuditTrail $model)
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
            ->setTableId('audittrails-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(8)
            ->buttons(
                Button::make('csv'),
                Button::make('excel'),
                Button::make('print'),
                Button::make('colvis'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            // Column::make('log_name'),
            Column::make('description'),
            Column::make('subject_type'),
            Column::make('subject_id'),
            Column::make('causer_type'),
            Column::make('causer_id'),
            Column::make('properties.ip')->title('Ip'),
            Column::make('properties.user_agent')->title('User Agent'),
            Column::make('created_at'),
            // Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    // protected function filename()
    // {
    //     return 'AuditTrails_' . date('YmdHis');
    // }
}
