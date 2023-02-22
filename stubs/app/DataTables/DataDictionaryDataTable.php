<?php

namespace App\DataTables;

use App\Models\Admin\Lookup;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DataDictionaryDataTable extends DataTable
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
            ->addIndexColumn()
            ->addColumn('action', function (Lookup $model) {
                return view('components.datatable-action', [
                    'id'    => 'dd-table',
                    'route' => [
                        'edit'    => route('admin.data-dictionary.edit', $model),
                        'destroy' => route('admin.data-dictionary.destroy', $model),
                    ],
                ])->toHtml();
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(config('app.date_format_human')) ?: null;
            })
            ->rawColumns(['action'])
        ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Lookup $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Lookup $model)
    {
        return $model->query()
            ->orderBy('key')
            ->orderBy('value_local');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dd-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3)
            ->buttons(
                Button::make('csv'),
                Button::make('excel'),
                Button::make('print'),
                Button::make('colvis'),
            )
            ->parameters([
                'searchDelay'  => 600,
                'initComplete' => "function () {
                    var _index = 0;
                    this.api().columns().every(function () {
                        _index++;

                        if (_index == 1 || _index == 7) {
                            $(input).appendTo('');
                        } else {
                            var type = (_index == 6) ? 'date' : 'text';
                            var column = this;
                            var input = document.createElement(\"input\");
                            $(input)
                                .prop('type', type)
                                .addClass(\"form-control form-control-sm\")
                                .appendTo($(column.footer()).empty())
                                .on('change keyup', function () {
                                    setTimeout(() => {
                                        column.search($(this).val(), false, false, true).draw();
                                    }, 600);
                                });
                        }
                    });
                }",
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
            Column::make('DT_RowIndex')->title('#')->sortable(false)->searchable(false),
            Column::make('key')->title('Key')->footer('Key'),
            Column::make('code')->title('Code')->footer('Code'),
            Column::make('value_local')->title('Value')->footer('Value'),
            Column::make('description')->title('Description')->footer('Description'),
            Column::make('created_at')->title('Created At')->footer('Created At'),
            Column::computed('action')->exportable(false)->printable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DataDictionary_' . date('YmdHis');
    }
}
