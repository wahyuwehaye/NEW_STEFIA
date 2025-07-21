@extends('layouts.admin')

@section('content')
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <h4 class="card-title">Pembayaran Per Metode</h4>
            
            <!-- Filter Metode -->
            <div class="method-filter mb-4">
                <form method="GET" action="{{ route('payments.by-method') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="payment_method" class="form-label">Filter Metode:</label>
                            <select id="payment_method" name="payment_method" class="form-control" onchange="this.form.submit()">
                                <option value="">-- Semua Metode --</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="debit_card" {{ request('payment_method') == 'debit_card' ? 'selected' : '' }}>Kartu Debit</option>
                                <option value="e_wallet" {{ request('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                                <option value="other" {{ request('payment_method') == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Statistik Metode -->
            <div class="row mb-4">
                <div class="col-lg-8">
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h6 class="card-title">Statistik Metode Pembayaran</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Metode</th>
                                            <th>Jumlah Transaksi</th>
                                            <th>Total Amount</th>
                                            <th>Persentase</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $methods = [
                                                'cash' => 'Tunai',
                                                'bank_transfer' => 'Transfer Bank',
                                                'credit_card' => 'Kartu Kredit',
                                                'debit_card' => 'Kartu Debit',
                                                'e_wallet' => 'E-Wallet',
                                                'other' => 'Lainnya'
                                            ];
                                            
                                            $methodStats = isset($paymentMethodStats) ? $paymentMethodStats : [];
                                        @endphp
                                        
                                        @forelse($methodStats as $method => $stats)
                                        <tr>
                                            <td>{{ $methods[$method] ?? $method }}</td>
                                            <td>{{ number_format($stats['count']) }}</td>
                                            <td>Rp {{ number_format($stats['total'], 0, ',', '.') }}</td>
                                            <td>{{ number_format($stats['percentage'], 1) }}%</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada data pembayaran</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h6 class="card-title">Distribusi Metode</h6>
                        </div>
                        <div class="card-body">
                            <div class="method-chart">
                                <canvas id="methodChart" style="max-height: 300px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Pembayaran -->
            @if(isset($payments) && $payments->count() > 0)
            <div class="card card-bordered">
                <div class="card-header">
                    <h6 class="card-title">Daftar Pembayaran
                        @if(request('payment_method'))
                            - {{ $methods[request('payment_method')] ?? request('payment_method') }}
                        @endif
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mahasiswa</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
                                    <td>{{ $payment->student->name ?? '-' }}</td>
                                    <td>{{ $methods[$payment->payment_method] ?? $payment->payment_method }}</td>
                                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payment->status == 'completed')
                                            <span class="badge badge-success">Selesai</span>
                                        @elseif($payment->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-outline-primary">
                                            <em class="icon ni ni-eye"></em>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-3">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js untuk distribusi metode pembayaran
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('methodChart').getContext('2d');
    
    @php
        $chartData = [];
        $chartLabels = [];
        if(isset($paymentMethodStats)) {
            foreach($paymentMethodStats as $method => $stats) {
                $chartLabels[] = $methods[$method] ?? $method;
                $chartData[] = $stats['count'];
            }
        }
    @endphp
    
    const data = {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            data: {!! json_encode($chartData) !!},
            backgroundColor: [
                '#ff6384',
                '#36a2eb',
                '#cc65fe',
                '#ffce56',
                '#4bc0c0',
                '#ff9f40'
            ],
            borderWidth: 1
        }]
    };
    
    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' transaksi';
                        }
                    }
                }
            }
        }
    };
    
    new Chart(ctx, config);
});
</script>
@endsection
