<?php

namespace App\DataTables;

use App\Models\Student;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Gate;

class StudentsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable(QueryBuilder $query): \Yajra\DataTables\EloquentDataTable
    {
        return parent::dataTable($query)
            ->editColumn('name', function ($student) {
                $initial = strtoupper(substr($student->name, 0, 1));
                return '<div class="user-card">' .
                       '<div class="user-avatar">' .
                       '<div class="avatar-initial">' . $initial . '</div>' .
                       '</div>' .
                       '<div class="user-info">' .
                       '<div class="lead-text">' . $student->name . '</div>' .
                       '<div class="sub-text">' . $student->nim . '</div>' .
                       '</div></div>';
            })
            ->editColumn('faculty', function ($student) {
                return '<div class="text-soft">' . ($student->faculty ?? 'N/A') . '</div>';
            })
            ->editColumn('department', function ($student) {
                return '<div class="text-soft">' . ($student->department ?? 'N/A') . '</div>';
            })
            ->editColumn('cohort_year', function ($student) {
                return '<div class="badge badge-outline-primary">' . ($student->cohort_year ?? 'N/A') . '</div>';
            })
            ->editColumn('current_semester', function ($student) {
                return '<div class="text-center">' . ($student->current_semester ?? 'N/A') . '</div>';
            })
            ->editColumn('status', function ($student) {
                $statusMap = [
                    'active' => ['class' => 'badge-success', 'text' => 'Aktif'],
                    'inactive' => ['class' => 'badge-warning', 'text' => 'Tidak Aktif'],
                    'graduated' => ['class' => 'badge-info', 'text' => 'Lulus'],
                    'dropped_out' => ['class' => 'badge-danger', 'text' => 'Drop Out']
                ];
                $status = $statusMap[$student->status] ?? ['class' => 'badge-secondary', 'text' => 'Unknown'];
                return '<span class="badge ' . $status['class'] . '">' . $status['text'] . '</span>';
            })
            ->editColumn('phone', function ($student) {
                return $student->phone ? '<a href="tel:' . $student->phone . '" class="text-primary">' . $student->phone . '</a>' : '<span class="text-soft">-</span>';
            })
            ->editColumn('email', function ($student) {
                return $student->email ? '<a href="mailto:' . $student->email . '" class="text-primary">' . $student->email . '</a>' : '<span class="text-soft">-</span>';
            })
            ->editColumn('created_at', function ($student) {
                return '<div class="text-soft">' . $student->created_at->format('d M Y') . '</div>';
            })
            ->addColumn('action', function ($student) {
                $actions = [];
                if ($this->canView($student)) {
                    $actions[] = '<a href="' . route('students.show', $student->id) . '" class="btn btn-sm btn-outline-primary" title="View"><em class="icon ni ni-eye"></em></a>';
                }
                if ($this->canEdit($student)) {
                    $actions[] = '<a href="' . route('students.edit', $student->id) . '" class="btn btn-sm btn-outline-warning" title="Edit"><em class="icon ni ni-edit"></em></a>';
                }
                if ($this->canDelete($student)) {
                    $actions[] = '<button class="btn btn-sm btn-outline-danger" onclick="deleteStudent(' . $student->id . ')" title="Delete"><em class="icon ni ni-trash"></em></button>';
                }
                return '<div class="btn-group">' . implode('', $actions) . '</div>';
            })
            ->rawColumns(['name', 'faculty', 'department', 'cohort_year', 'current_semester', 'status', 'phone', 'email', 'created_at', 'action']);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return Student::query()
            ->select([
                'students.*',
            ])
            ->when(request()->has('status'), function ($query) {
                $query->where('status', request()->get('status'));
            })
            ->when(request()->has('faculty'), function ($query) {
                $query->where('faculty', request()->get('faculty'));
            })
            ->when(request()->has('department'), function ($query) {
                $query->where('department', request()->get('department'));
            })
            ->when(request()->has('cohort_year'), function ($query) {
                $query->where('cohort_year', request()->get('cohort_year'));
            });
    }

    /**
     * Get the dataTable columns definition.
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Mahasiswa', 'orderable' => true, 'searchable' => true],
            ['data' => 'faculty', 'name' => 'faculty', 'title' => 'Fakultas', 'orderable' => true, 'searchable' => true],
            ['data' => 'department', 'name' => 'department', 'title' => 'Program Studi', 'orderable' => true, 'searchable' => true],
            ['data' => 'cohort_year', 'name' => 'cohort_year', 'title' => 'Angkatan', 'orderable' => true, 'searchable' => true],
            ['data' => 'current_semester', 'name' => 'current_semester', 'title' => 'Semester', 'orderable' => true, 'searchable' => false],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => true, 'searchable' => true],
            ['data' => 'phone', 'name' => 'phone', 'title' => 'Telepon', 'orderable' => false, 'searchable' => true],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email', 'orderable' => false, 'searchable' => true],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Tanggal Daftar', 'orderable' => true, 'searchable' => false],
            ['data' => 'action', 'name' => 'action', 'title' => 'Aksi', 'orderable' => false, 'searchable' => false, 'width' => '100px'],
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'Students_' . date('YmdHis');
    }

    /**
     * Global search implementation
     */
    protected function globalSearch(QueryBuilder $query, string $search): void
    {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('faculty', 'like', "%{$search}%")
              ->orWhere('department', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    /**
     * Column search implementation
     */
    protected function columnSearch(QueryBuilder $query, string $column, string $search): void
    {
        switch ($column) {
            case 'name':
                $query->where('name', 'like', "%{$search}%");
                break;
            case 'email':
                $query->where('email', 'like', "%{$search}%");
                break;
            case 'nim':
                $query->where('nim', 'like', "%{$search}%");
                break;
            case 'faculty':
                $query->where('faculty', 'like', "%{$search}%");
                break;
            case 'department':
                $query->where('department', 'like', "%{$search}%");
                break;
            case 'phone':
                $query->where('phone', 'like', "%{$search}%");
                break;
            case 'status':
                $query->where('status', $search);
                break;
            case 'cohort_year':
                $query->where('cohort_year', $search);
                break;
        }
    }

    /**
     * Permission methods
     */
    protected function canView($row): bool
    {
        return true; // Temporarily disable Gate permissions
    }

    protected function canEdit($row): bool
    {
        return true; // Temporarily disable Gate permissions
    }

    protected function canDelete($row): bool
    {
        return true; // Temporarily disable Gate permissions
    }

    /**
     * URL methods
     */
    protected function getViewUrl($row): string
    {
        return route('students.show', $row->id);
    }

    protected function getEditUrl($row): string
    {
        return route('students.edit', $row->id);
    }

    /**
     * Transform row data for client-side processing
     */
    protected function transformRowForClientSide($row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
            'student_id' => $row->student_id,
            'email' => $row->email,
            'program_study' => $row->program_study,
            'class' => $row->class,
            'status' => $row->status,
            'outstanding_amount' => $row->outstanding_amount ?? 0,
            'created_at' => $row->created_at?->format('d/m/Y H:i'),
        ];
    }

    /**
     * Get buttons
     */
    protected function getButtons(): array
    {
        return array_merge([
            'create' => '<i class="fas fa-plus"></i> Add Student',
            'excel' => '<i class="fas fa-file-excel"></i> Excel',
            'pdf' => '<i class="fas fa-file-pdf"></i> PDF',
        ], parent::getButtons());
    }
}
