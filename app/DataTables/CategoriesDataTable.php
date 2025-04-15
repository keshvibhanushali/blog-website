<?php
namespace App\DataTables;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('select', function($row){
                $checkbox='<input type="checkbox" value="'.$row->id.'" class="checkbox"><br>';
                return $checkbox;
            })
            ->addColumn('action', function ($row) {
                $button = '';
                $button .= '<button type="button" class="btn btn-sm btn-primary" data-id="' . $row->id . '" id="edit-btn">Edit<i class="fas fa-recycle mt-1"></i></button>';
                $button .= '<button type="button" class=" ml-2 btn btn-sm btn-danger" data-id="' . $row->id . '" id="delete-btn">Delete</button>';
                $html = '<div class="d-flex justify">' . $button . '</div>';
                return $html;
            })
            // ->editColumn('status', function ($row) {
            //     $button = '';
            //     $button .= '<div class="custom-control custom-switch">
            //                 <input type="checkbox" class="custom-control-input" id="switchBtn" data-id="' . $row->id . '" >
            //                 <label class="custom-control-label" for="switchBtn"></label>
            //                 </div>';
            //     $html = '<div class="d-flex justify">' . $button . '</div>';
            //     return $html;
            // })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('Y-m-d');
            })
            ->setRowId('id')
            ->rawColumns(['status', 'action','select']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Category $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('data-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
        //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload'),
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('select')->title('<input type="checkbox" class="checkboxMain checkAll" name="checkboxMain" >'),
            Column::make('id'),
            Column::make('name'),
            Column::make('slug'),
            Column::make('status'),
            Column::make('created_at'),
            Column::make('updated_at'),
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
        return 'Categories_' . date('YmdHis');
    }
}
