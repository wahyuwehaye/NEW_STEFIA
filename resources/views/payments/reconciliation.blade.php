@extends('layouts.admin')

@section('content')
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <h4 class="card-title">Rekonsiliasi Pembayaran</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Status Sistem</th>
                        <th>Status Bank</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>TRX001</td>
                        <td>Completed</td>
                        <td>Confirmed</td>
                        <td><button class="btn btn-success" disabled>Terespons</button></td>
                    </tr>
                    <tr>
                        <td>TRX002</td>
                        <td>Pending</td>
                        <td>Confirmed</td>
                        <td><button class="btn btn-primary">Rekonsiliasi</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
