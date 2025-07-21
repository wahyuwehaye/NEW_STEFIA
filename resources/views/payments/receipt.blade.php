<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran #{{ $payment->payment_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ddd;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .subtitle {
            color: #666;
            margin-top: 5px;
        }
        .receipt-number {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
            color: #007bff;
        }
        .content {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .left-column, .right-column {
            flex: 1;
        }
        .right-column {
            margin-left: 40px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #333;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            color: #666;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #28a745;
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border: 2px solid #28a745;
            border-radius: 8px;
            margin: 30px 0;
        }
        .footer {
            border-top: 2px solid #ddd;
            padding-top: 20px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .verified-badge {
            background-color: #28a745;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                margin: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="logo">STEFIA</div>
            <div class="subtitle">Sistem Informasi Keuangan Akademik</div>
            <div class="receipt-number">KUITANSI PEMBAYARAN</div>
            <div class="receipt-number">#{{ $payment->payment_code }}</div>
            <span class="verified-badge">TERVERIFIKASI</span>
        </div>

        <div class="content">
            <div class="left-column">
                <div class="field">
                    <span class="field-label">Mahasiswa</span>
                    <div class="field-value">{{ $payment->student->name ?? 'N/A' }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">NIM</span>
                    <div class="field-value">{{ $payment->student->nim ?? 'N/A' }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Tanggal Pembayaran</span>
                    <div class="field-value">{{ $payment->payment_date->format('d F Y') }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Metode Pembayaran</span>
                    <div class="field-value">{{ $payment->payment_method_label }}</div>
                </div>
            </div>

            <div class="right-column">
                <div class="field">
                    <span class="field-label">Tipe Pembayaran</span>
                    <div class="field-value">{{ $payment->payment_type_label }}</div>
                </div>
                
                @if($payment->reference_number)
                <div class="field">
                    <span class="field-label">Nomor Referensi</span>
                    <div class="field-value">{{ $payment->reference_number }}</div>
                </div>
                @endif
                
                <div class="field">
                    <span class="field-label">Petugas</span>
                    <div class="field-value">{{ $payment->user->name ?? 'N/A' }}</div>
                </div>
                
                <div class="field">
                    <span class="field-label">Tanggal Cetak</span>
                    <div class="field-value">{{ now()->format('d F Y H:i') }}</div>
                </div>
            </div>
        </div>

        <div class="amount">
            JUMLAH: {{ $payment->formatted_amount }}
        </div>

        @if($payment->description)
        <div class="field">
            <span class="field-label">Deskripsi</span>
            <div class="field-value">{{ $payment->description }}</div>
        </div>
        @endif

        @if($payment->notes)
        <div class="field">
            <span class="field-label">Catatan</span>
            <div class="field-value">{{ $payment->notes }}</div>
        </div>
        @endif

        <div class="footer">
            <p>Kuitansi ini sah dan telah diverifikasi secara sistem.</p>
            <p>Dicetak pada {{ now()->format('d F Y H:i:s') }}</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
