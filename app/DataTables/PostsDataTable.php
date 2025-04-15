<?php

namespace App\DataTables;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class PostsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('select', function ($row) {
                $checkbox = '<input type="checkbox" value="' . $row->id . '" class="checkbox"><br>';
                return $checkbox;
            })
            ->addColumn('thumbnail', function ($row) {
                $url = asset('storage/' . $row->thumbnail);
                $thumbnail = '<img src="' . $url . '" width="70">';
                return $thumbnail;
            })
            ->addColumn('action', function ($row) {
                $button = '';
                $button .= '<a href="' . route("edit-post", $row->id) . '"><button type="button" class="btn btn-sm btn-primary" data-id="' . $row->id . '" id="edit-btn">Edit<i class="mt-1 fas fa-recycle"></i></button></a>';
                $button .= '<button type="button" class="ml-2  btn btn-sm btn-danger" data-id="' . $row->id . '" id="delete-btn">Delete</button>';
                $html = '<div class="d-flex justify">' . $button . '</div>';
                return $html;
            })
            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d');
            })
            ->editColumn('updated_at', function ($row) {
                return Carbon::parse($row->updated_at)->format('Y-m-d');
            })
            ->setRowId('id')
            ->rawColumns(['Delete', 'thumbnail', 'action', 'select']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Post $model): QueryBuilder
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
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('select')->title('<input type="checkbox" class="mainCheckbox" name="mainCheckbox">'),
            Column::make('id'),
            Column::make('title'),
            Column::make('excerpt'),
            Column::computed('thumbnail'),
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
        return 'Posts_' . date('YmdHis');
    }
}
