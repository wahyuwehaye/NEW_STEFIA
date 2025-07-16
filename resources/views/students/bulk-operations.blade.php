@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Bulk Operations</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Student Bulk Operations</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('students.bulk-action') }}">
                @csrf
                
                <div class="form-group">
                    <label for="action">Action</label>
                    <select name="action" id="action" class="form-control" required>
                        <option value="">Select Action</option>
                        <option value="activate">Activate</option>
                        <option value="deactivate">Deactivate</option>
                        <option value="delete">Delete</option>
                        <option value="export">Export</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="student_ids">Student IDs (comma separated)</label>
                    <textarea name="student_ids" id="student_ids" class="form-control" rows="3" placeholder="1,2,3,4,5" required></textarea>
                    <small class="form-text text-muted">Enter student IDs separated by commas</small>
                </div>
                
                <button type="submit" class="btn btn-primary">Execute Action</button>
            </form>
        </div>
    </div>
</div>
@endsection
