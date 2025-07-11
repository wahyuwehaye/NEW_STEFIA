@extends('layouts.admin')

@section('title', 'Students Management')

@section('content')
<x-page-header 
    title="Students Management" 
    subtitle="Manage student registration and information"
    :breadcrumbs="[
        ['title' => 'Students', 'url' => route('students.index')],
        ['title' => 'All Students']
    ]">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-filter-alt"></em><span>Filter</span></a></li>
            <li class="nk-block-tools-opt"><a href="{{ route('students.create') }}" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add Student</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<!-- Student Statistics -->
<div class="nk-block">
    <div class="row g-gs">
        <x-stats-card 
            title="Total Students" 
            value="1,245" 
            change="4.63%" 
            changeType="up" 
            tooltip="Total registered students" />
            
        <x-stats-card 
            title="Active Students" 
            value="1,178" 
            change="2.1%" 
            changeType="up" 
            tooltip="Currently active students" />
            
        <x-stats-card 
            title="New This Month" 
            value="67" 
            change="15.8%" 
            changeType="up" 
            tooltip="New students this month" />
            
        <x-stats-card 
            title="Graduated" 
            value="342" 
            change="8.4%" 
            changeType="up" 
            tooltip="Students graduated this year" />
    </div>
</div>

<!-- Students Table -->
<div class="nk-block nk-block-lg">
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Students List</h6>
                </div>
                <div class="card-tools">
                    <div class="form-inline flex-nowrap gx-3">
                        <div class="form-wrap w-150px">
                            <select class="form-select js-select2" data-search="off" data-placeholder="Bulk Action">
                                <option value="">Bulk Action</option>
                                <option value="email">Send Email</option>
                                <option value="suspend">Suspend</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div class="form-wrap w-150px">
                            <select class="form-select js-select2" data-search="off" data-placeholder="Status">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="suspend">Suspend</option>
                            </select>
                        </div>
                        <div class="btn-wrap">
                            <span class="d-none d-md-block"><button class="btn btn-dim btn-outline-light disabled">Apply</button></span>
                            <span class="d-md-none"><button class="btn btn-dim btn-outline-light btn-icon disabled"><em class="icon ni ni-arrow-right"></em></button></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid">
                                <label class="custom-control-label" for="uid"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col"><span class="sub-text">Student</span></div>
                        <div class="nk-tb-col tb-col-mb"><span class="sub-text">Program</span></div>
                        <div class="nk-tb-col tb-col-md"><span class="sub-text">Phone</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Registered</span></div>
                        <div class="nk-tb-col tb-col-lg"><span class="sub-text">Status</span></div>
                        <div class="nk-tb-col nk-tb-col-tools text-end">
                            <div class="dropdown">
                                <a href="#" class="btn btn-xs btn-outline-light btn-icon dropdown-toggle" data-bs-toggle="dropdown" data-offset="0,5"><em class="icon ni ni-plus"></em></a>
                                <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end">
                                    <ul class="link-tidy sm no-bdr">
                                        <li>
                                            <div class="item-col">
                                                <span class="sub-text">Show</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item-col">
                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="ph">
                                                    <label class="custom-control-label" for="ph">Phone</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item-col">
                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="vri" checked>
                                                    <label class="custom-control-label" for="vri">Verified</label>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item-col">
                                                <div class="custom-control custom-control-sm custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="st">
                                                    <label class="custom-control-label" for="st">Status</label>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Students Data from Controller -->
                    @foreach($students as $student)
                    <div class="nk-tb-item">
                        <div class="nk-tb-col nk-tb-col-check">
                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                <input type="checkbox" class="custom-control-input" id="uid{{ $student['id'] }}">
                                <label class="custom-control-label" for="uid{{ $student['id'] }}"></label>
                            </div>
                        </div>
                        <div class="nk-tb-col">
                            <div class="user-card">
                                <div class="user-avatar bg-primary">
                                    <span>{{ strtoupper(substr($student['name'], 0, 2)) }}</span>
                                </div>
                                <div class="user-info">
                                    <span class="tb-lead">{{ $student['name'] }} <span class="dot dot-{{ $student['status'] == 'Active' ? 'success' : 'danger' }} d-md-none ms-1"></span></span>
                                    <span class="tb-sub">{{ $student['email'] }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="nk-tb-col tb-col-mb">
                            <span class="tb-amount">{{ $student['class'] }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-md">
                            <span>+62 123-456-789</span>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <span>{{ now()->subDays(rand(30, 365))->format('d M Y') }}</span>
                        </div>
                        <div class="nk-tb-col tb-col-lg">
                            <span class="tb-status text-{{ $student['status'] == 'Active' ? 'success' : 'danger' }}">{{ $student['status'] }}</span>
                        </div>
                        <div class="nk-tb-col nk-tb-col-tools">
                            <ul class="nk-tb-actions gx-1">
                                <li class="nk-tb-action-hidden">
                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Send Email">
                                        <em class="icon ni ni-mail-fill"></em>
                                    </a>
                                </li>
                                <li class="nk-tb-action-hidden">
                                    <a href="#" class="btn btn-trigger btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspend">
                                        <em class="icon ni ni-user-cross-fill"></em>
                                    </a>
                                </li>
                                <li>
                                    <div class="drodown">
                                        <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="{{ route('students.show', $student['id']) }}"><em class="icon ni ni-eye"></em><span>View Details</span></a></li>
                                                <li><a href="{{ route('students.edit', $student['id']) }}"><em class="icon ni ni-edit"></em><span>Edit Student</span></a></li>
                                                <li><a href="#"><em class="icon ni ni-activity-round"></em><span>Activities</span></a></li>
                                                <li class="divider"></li>
                                                <li><a href="#"><em class="icon ni ni-shield-star"></em><span>Reset Pass</span></a></li>
                                                <li><a href="#" class="text-danger"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card-inner">
                <div class="nk-block-between-md g-3">
                    <div class="g">
                        <ul class="pagination justify-content-center justify-content-md-start">
                            <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><span class="page-link"><em class="icon ni ni-more-h"></em></span></li>
                            <li class="page-item"><a class="page-link" href="#">6</a></li>
                            <li class="page-item"><a class="page-link" href="#">7</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </div>
                    <div class="g">
                        <div class="pagination-goto d-flex justify-content-center justify-content-md-end gx-3">
                            <div>Page</div>
                            <div>
                                <select class="form-select js-select2" data-search="off" data-placeholder="1">
                                    <option value="page-1">1</option>
                                    <option value="page-2">2</option>
                                    <option value="page-3">3</option>
                                    <option value="page-4">4</option>
                                    <option value="page-5">5</option>
                                    <option value="page-6">6</option>
                                    <option value="page-7">7</option>
                                </select>
                            </div>
                            <div>OF 7</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
