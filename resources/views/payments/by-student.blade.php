@extends('layouts.admin')

@section('content')
<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <h4 class="card-title">Pembayaran Per Mahasiswa</h4>
            
            <!-- Filter Mahasiswa -->
            <div class="student-filter mb-4">
                <form method="GET" action="{{ route('payments.by-student') }}">
                    <label for="student" class="form-label">Pilih Mahasiswa:</label>
                    <select id="student" name="student_id" class="form-control" onchange="this.form.submit()">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($students ?? [] as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Detail Mahasiswa -->
            @if(isset($selectedStudent) && $selectedStudent)
            <div class="student-details card card-bordered mt-4">
                <div class="card-header">
                    <h5 class="card-title">{{ $selectedStudent->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>NIM:</strong> {{ $selectedStudent->nim ?? '-' }}</p>
                            <p><strong>Email:</strong> {{ $selectedStudent->email ?? '-' }}</p>
                            <p><strong>Program Studi:</strong> {{ $selectedStudent->program_studi ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Piutang:</strong> 
                                <span class="text-danger">Rp {{ number_format($selectedStudent->total_receivables ?? 0, 0, ',', '.') }}</span>
                            </p>
                            <p><strong>Total Pembayaran:</strong> 
                                <span class="text-success">Rp {{ number_format($selectedStudent->total_payments ?? 0, 0, ',', '.') }}</span>
                            </p>
                            <p><strong>Sisa Tagihan:</strong> 
                                <span class="text-warning">Rp {{ number_format(($selectedStudent->total_receivables ?? 0) - ($selectedStudent->total_payments ?? 0), 0, ',', '.') }}</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('payments.create', ['student_id' => $selectedStudent->id]) }}" class="btn btn-primary">
                            <em class="icon ni ni-plus"></em> Tambah Pembayaran
                        </a>
                        <button type="button" class="btn btn-secondary" onclick="sendReminder({{ $selectedStudent->id }})">
                            <em class="icon ni ni-mail"></em> Kirim Pengingat
                        </button>
                        <a href="{{ route('students.show', $selectedStudent->id) }}" class="btn btn-outline-primary">
                            <em class="icon ni ni-eye"></em> Lihat Detail
                        </a>
                    </div>
                </div>
            </div>

            <!-- Daftar Pembayaran -->
            @if(isset($payments) && $payments->count() > 0)
            <div class="card card-bordered mt-4">
                <div class="card-header">
                    <h6 class="card-title">Riwayat Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
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
                                    <td>{{ $payment->description ?? '-' }}</td>
                                    <td>{{ $payment->payment_method ?? '-' }}</td>
                                    <td>Rp {{ number_format($payment->amount ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @if($payment->status == 'verified')
                                            <span class="badge badge-success">Terverifikasi</span>
                                        @elseif($payment->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
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
                </div>
            </div>
            @endif
            @endif

            <!-- Jika belum ada mahasiswa dipilih -->
            @if(!isset($selectedStudent) || !$selectedStudent)
            <div class="card card-bordered mt-4">
                <div class="card-body text-center">
                    <em class="icon ni ni-user" style="font-size: 3rem; color: #ccc;"></em>
                    <h6 class="mt-3">Pilih Mahasiswa</h6>
                    <p class="text-muted">Silakan pilih mahasiswa dari dropdown di atas untuk melihat detail pembayaran.</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
function sendReminder(studentId) {
    if(confirm('Kirim pengingat pembayaran ke mahasiswa ini?')) {
        // AJAX call untuk kirim pengingat
        fetch(`/payments/send-reminder/${studentId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('Pengingat berhasil dikirim!');
            } else {
                alert('Gagal mengirim pengingat: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}
</script>
@endsection
