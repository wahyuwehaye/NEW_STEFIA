@extends('layouts.admin')

@section('title', 'Payment Verification')

@section('content')
<h1>Payment Verification</h1>
<p>Here you can verify payments made by students. Please select a payment to verify.</p>

<!-- Example Table -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Student Name</th>
            <th scope="col">Payment Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th scope="row">1</th>
            <td>John Doe</td>
            <td>Rp 1,500,000</td>
            <td>Pending</td>
            <td><button class="btn btn-success">Verify</button></td>
        </tr>
        <tr>
            <th scope="row">2</th>
            <td>Jane Smith</td>
            <td>Rp 2,000,000</td>
            <td>Pending</td>
            <td><button class="btn btn-success">Verify</button></td>
        </tr>
    </tbody>
</table>
@endsection
