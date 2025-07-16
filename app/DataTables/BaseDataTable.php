<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseDataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable(QueryBuilder $query): \Yajra\DataTables\EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()
            ->setRowId('id')
            ->addColumn('action', function ($row) {
                return $this->getActionColumn($row);
            })
            ->rawColumns(['action'])
            ->filter(function ($query) {
                $this->applyFilters($query);
            });
    }

    /**
     * Get query source of dataTable.
     */
    abstract public function query(): QueryBuilder;

    /**
     * Apply filters to query
     */
    protected function applyFilters(QueryBuilder $query): void
    {
        $request = request();
        
        // Global search
        if ($request->has('search') && !empty($request->get('search')['value'])) {
            $search = $request->get('search')['value'];
            $this->globalSearch($query, $search);
        }
        
        // Column search
        if ($request->has('columns')) {
            foreach ($request->get('columns') as $column) {
                if (!empty($column['search']['value'])) {
                    $this->columnSearch($query, $column['data'], $column['search']['value']);
                }
            }
        }
    }

    /**
     * Global search implementation - override in child classes
     */
    protected function globalSearch(QueryBuilder $query, string $search): void
    {
        // Default implementation - override in child classes
    }

    /**
     * Column search implementation - override in child classes
     */
    protected function columnSearch(QueryBuilder $query, string $column, string $search): void
    {
        // Default implementation - override in child classes
    }

    /**
     * Get client-side data for small datasets
     */
    protected function getClientSideData(): array
    {
        return $this->query()->get()->map(function ($row) {
            return $this->transformRowForClientSide($row);
        })->toArray();
    }

    /**
     * Transform row data for client-side processing
     */
    protected function transformRowForClientSide($row): array
    {
        return $row->toArray();
    }

    /**
     * Get server-side parameters
     */
    protected function getServerSideParameters(): array
    {
        return [
            'processing' => true,
            'serverSide' => true,
            'responsive' => true,
            'autoWidth' => false,
            'stateSave' => true,
            'pageLength' => 25,
            'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            'language' => [
                'processing' => '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
                'search' => 'Search:',
                'lengthMenu' => 'Show _MENU_ entries',
                'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                'infoFiltered' => '(filtered from _MAX_ total entries)',
                'paginate' => [
                    'first' => 'First',
                    'last' => 'Last',
                    'next' => 'Next',
                    'previous' => 'Previous',
                ],
            ],
        ];
    }

    /**
     * Get action column HTML
     */
    protected function getActionColumn($row): string
    {
        $actions = [];
        
        if ($this->canView($row)) {
            $actions[] = '<a href="' . $this->getViewUrl($row) . '" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>';
        }
        
        if ($this->canEdit($row)) {
            $actions[] = '<a href="' . $this->getEditUrl($row) . '" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>';
        }
        
        if ($this->canDelete($row)) {
            $actions[] = '<button onclick="confirmDelete(' . $row->id . ')" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>';
        }

        return '<div class="btn-group">' . implode('', $actions) . '</div>';
    }

    /**
     * Permission methods - override in child classes
     */
    protected function canView($row): bool
    {
        return true;
    }

    protected function canEdit($row): bool
    {
        return true;
    }

    protected function canDelete($row): bool
    {
        return true;
    }

    /**
     * URL methods - override in child classes
     */
    protected function getViewUrl($row): string
    {
        return '#';
    }

    protected function getEditUrl($row): string
    {
        return '#';
    }

    protected function getDeleteUrl($row): string
    {
        return '#';
    }

    /**
     * Get table ID
     */
    protected function getTableId(): string
    {
        return class_basename($this) . '-table';
    }

    /**
     * Get DOM configuration
     */
    protected function getDom(): string
    {
        return "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
               "<'row'<'col-sm-12'tr>>" .
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
    }

    /**
     * Get default order
     */
    protected function getDefaultOrder(): array
    {
        return [0, 'desc'];
    }

    /**
     * Get buttons
     */
    protected function getButtons(): array
    {
        return [
            'export' => '<i class="fas fa-download"></i> Export',
            'print' => '<i class="fas fa-print"></i> Print',
            'reset' => '<i class="fas fa-undo"></i> Reset',
            'reload' => '<i class="fas fa-sync"></i> Reload',
        ];
    }

    /**
     * Get columns
     */
    abstract protected function getColumns(): array;

    /**
     * Get parameters
     */
    protected function getParameters(): array
    {
        return [];
    }

    /**
     * Apply custom search filters
     */
    protected function applyCustomSearch(QueryBuilder $query, string $search): void
    {
        // Default implementation - override in child classes
    }

    /**
     * Get query for counting
     */
    protected function getQuery(): QueryBuilder
    {
        return $this->query();
    }

    /**
     * Render the DataTable
     */
    public function render($view = null, $data = [], $mergeData = [])
    {
        if (request()->ajax()) {
            return $this->dataTable($this->query())->make(true);
        }

        // For non-ajax requests, return the view with necessary data
        $tableConfig = [
            'ajax' => request()->url(),
            'columns' => $this->getColumnDefinitions(),
            'processing' => true,
            'serverSide' => true,
            'responsive' => true,
            'autoWidth' => false,
            'pageLength' => 25,
            'order' => $this->getDefaultOrder(),
            'dom' => $this->getDom(),
            'language' => [
                'processing' => '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"></div></div>',
                'search' => 'Search:',
                'lengthMenu' => 'Show _MENU_ entries',
                'info' => 'Showing _START_ to _END_ of _TOTAL_ entries',
                'infoEmpty' => 'Showing 0 to 0 of 0 entries',
                'infoFiltered' => '(filtered from _MAX_ total entries)',
                'paginate' => [
                    'first' => 'First',
                    'last' => 'Last',
                    'next' => 'Next',
                    'previous' => 'Previous',
                ],
            ],
        ];
        
        return view($view, array_merge([
            'tableId' => $this->getTableId(),
            'tableConfig' => $tableConfig,
        ], $data), $mergeData);
    }

    /**
     * Get column definitions for DataTables
     */
    protected function getColumnDefinitions(): array
    {
        $columns = [];
        
        // Add row index column
        $columns[] = [
            'data' => 'DT_RowIndex',
            'name' => 'DT_RowIndex',
            'title' => '#',
            'orderable' => false,
            'searchable' => false,
            'width' => '50px'
        ];
        
        // Add custom columns from child class
        foreach ($this->getColumns() as $column) {
            if (is_array($column)) {
                $columns[] = $column;
            }
        }
        
        // Add action column
        $columns[] = [
            'data' => 'action',
            'name' => 'action',
            'title' => 'Action',
            'orderable' => false,
            'searchable' => false,
            'width' => '120px',
            'className' => 'text-center'
        ];
        
        return $columns;
    }
}
