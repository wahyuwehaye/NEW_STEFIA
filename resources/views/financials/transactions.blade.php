@extends('layouts.admin')

@section('title', 'Financial Transactions')

@section('content')
<x-page-header 
    title="Financial Transactions" 
    subtitle="View and manage all financial transactions"
    :breadcrumbs="[
        ['title' => 'Financial', 'url' => '#'],
        ['title' => 'Transactions']
    ]">
    <x-slot name="actions">
        <ul class="nk-block-tools g-3">
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-download-cloud"></em><span>Export</span></a></li>
            <li><a href="#" class="btn btn-white btn-outline-light"><em class="icon ni ni-filter-alt"></em><span>Filter</span></a></li>
            <li class="nk-block-tools-opt"><a href="#" class="btn btn-primary"><em class="icon ni ni-plus"></em><span>Add Transaction</span></a></li>
        </ul>
    </x-slot>
</x-page-header>

<div class="nk-block nk-block-lg">
    <div class="card card-bordered card-preview">
        <div class="card-inner">
            <div class="card-title-group">
                <div class="card-title">
                    <h6 class="title">Recent Transactions</h6>
                </div>
            </div>
            <div class="card-inner p-0">
                <div class="nk-tb-list nk-tb-ulist">
                    <div class="nk-tb-item nk-tb-head">
                        <div class="nk-tb-col"><span class="sub-text">Date</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Type</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Description</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Amount</span></div>
                        <div class="nk-tb-col"><span class="sub-text">Status</span></div>
                    </div>
                    
                    <div class="nk-tb-item">
                        <div class="nk-tb-col">
                            <span>{{ now()->format('d M Y') }}</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-status text-primary">Fee Payment</span>
                        </div>
                        <div class="nk-tb-col">
                            <span>Monthly school fee payment</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-amount text-success">+$500.00</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-status text-success">Completed</span>
                        </div>
                    </div>
                    
                    <div class="nk-tb-item">
                        <div class="nk-tb-col">
                            <span>{{ now()->subDays(1)->format('d M Y') }}</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-status text-info">Scholarship</span>
                        </div>
                        <div class="nk-tb-col">
                            <span>Scholarship disbursement</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-amount text-danger">-$1,000.00</span>
                        </div>
                        <div class="nk-tb-col">
                            <span class="tb-status text-success">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
