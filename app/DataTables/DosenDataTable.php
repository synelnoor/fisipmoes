<?php

namespace App\DataTables;

use App\Models\Dosen;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class DosenDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'dosens.datatables_actions')
            ->editColumn('fakultas_id','{{ $fakultas["nama"]}}');;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Post $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dosen $model)
    {
        $model = Dosen::with('fakultas');
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
            ->addAction(['width' => '80px'])
            ->parameters([
                'dom'     => 'Bfrtip',
                'order'   => [[0, 'desc']],
                'buttons' => [
                    'create',
                    'export',
                    'print',
                    'reset',
                    'reload',
                ],
                // 'initComplete' => "function() {
                //     this.api().columns().every(function() {
                //         var column = this;
                //         var input = document.createElement(\"input\");
                //         $(input).appendTo($(column.footer()).empty())
                //         .on('change', function () {
                //             column.search($(this).val(), false, false, true).draw();
                //         });
                //     });
                // }",
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
            //'id',
            'nama',
            'jabatan',
            'file'=>['name' => 'File', 'data' => 'file', 'render' => '"<img src=\""+data+"\" height=\"50\"/>"'],
            'fakultas'=>['name' => 'Fakultas', 'data' => 'fakultas_id'],
            'desc',
            'line',
            'col'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'dosensdatatable_' . time();
    }
}