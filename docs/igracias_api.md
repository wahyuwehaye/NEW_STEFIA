# Dokumentasi API iGracias untuk STEFIA

## Autentikasi
**Endpoint:** `POST /auth/login`

**Request:**
```json
{
  "username": "string",
  "password": "string",
  "client_id": "string",
  "client_secret": "string"
}
```
**Response:**
```json
{
  "data": {
    "access_token": "string"
  }
}
```

---

## Mahasiswa (Students)
### List Mahasiswa
**Endpoint:** `GET /students`

**Query Params:** `page`, `per_page`, filter lain sesuai kebutuhan

**Headers:** `Authorization: Bearer {access_token}`

**Response:**
```json
{
  "data": {
    "students": [
      {
        "nim": "DUMMY001",
        "name": "Dummy Student",
        "email": "dummy@student.ac.id",
        "faculty": "Dummy Faculty",
        "status": "active"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1
    }
  }
}
```

### Detail Mahasiswa
**Endpoint:** `GET /students/{nim}`

**Response:**
```json
{
  "data": {
    "nim": "DUMMY001",
    "name": "Dummy Student",
    "email": "dummy@student.ac.id",
    "phone": "08123456789",
    "birth_place": "Bandung",
    "birth_date": "2000-01-01",
    "faculty": "Dummy Faculty",
    "department": "Teknik Informatika",
    "cohort_year": 2019,
    "current_semester": 8,
    "status": "active",
    "total_outstanding": 5000000,
    "outstanding_semesters": 1,
    "last_payment_date": "2024-01-01",
    "is_reminded": false,
    "external_id": "igracias-001"
  }
}
```

---

## Pembayaran (Payments)
### List Pembayaran
**Endpoint:** `GET /payments`

**Query Params:** `page`, `per_page`, `nim`, `status`, `date_from`, `date_to`

**Response:**
```json
{
  "data": {
    "payments": [
      {
        "payment_id": "PAY001",
        "nim": "2019001",
        "name": "Ahmad Fauzi",
        "amount": 2500000,
        "payment_date": "2024-01-10",
        "payment_method": "bank_transfer",
        "payment_type": "SPP",
        "status": "completed",
        "description": "Pembayaran SPP Semester 8",
        "reference_number": "INV-20240110-001"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1
    }
  }
}
```

### Detail Pembayaran
**Endpoint:** `GET /payments/{payment_id}`

**Response:**
```json
{
  "data": {
    "payment_id": "PAY001",
    "nim": "2019001",
    "name": "Ahmad Fauzi",
    "amount": 2500000,
    "payment_date": "2024-01-10",
    "payment_method": "bank_transfer",
    "payment_type": "SPP",
    "status": "completed",
    "description": "Pembayaran SPP Semester 8",
    "reference_number": "INV-20240110-001"
  }
}
```

---

## Piutang (Receivables)
### List Piutang
**Endpoint:** `GET /receivables`

**Query Params:** `page`, `per_page`, `nim`, `status`, `due_date_from`, `due_date_to`

**Response:**
```json
{
  "data": {
    "receivables": [
      {
        "receivable_id": "RCV001",
        "nim": "2019001",
        "name": "Ahmad Fauzi",
        "fee_type": "SPP",
        "amount": 2500000,
        "paid_amount": 1000000,
        "outstanding_amount": 1500000,
        "due_date": "2024-02-01",
        "status": "partial",
        "description": "SPP Semester 8"
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1
    }
  }
}
```

### Detail Piutang
**Endpoint:** `GET /receivables/{receivable_id}`

**Response:**
```json
{
  "data": {
    "receivable_id": "RCV001",
    "nim": "2019001",
    "name": "Ahmad Fauzi",
    "fee_type": "SPP",
    "amount": 2500000,
    "paid_amount": 1000000,
    "outstanding_amount": 1500000,
    "due_date": "2024-02-01",
    "status": "partial",
    "description": "SPP Semester 8"
  }
}
```

---

## Dummy Endpoint (local/testing)
Jika environment `local` atau `testing`, seluruh endpoint di atas akan mengembalikan data dummy seperti contoh di atas.

---

## Error Handling & Retry
- Jika gagal, response error akan dicatat ke model `SyncLog` (status, body, filters).
- Retry otomatis hingga 3x dengan backoff 1, 2, 4 detik.

---

## Penjelasan Field
- `payment_id`, `receivable_id`: ID unik transaksi/piutang
- `nim`: Nomor Induk Mahasiswa
- `name`: Nama mahasiswa
- `amount`: Nominal total
- `paid_amount`: Nominal yang sudah dibayar (piutang)
- `outstanding_amount`: Sisa yang belum dibayar (piutang)
- `payment_date`: Tanggal pembayaran
- `due_date`: Jatuh tempo piutang
- `payment_method`: Metode pembayaran (bank_transfer, cash, dsb)
- `payment_type`/`fee_type`: Jenis pembayaran/biaya (SPP, SKS, dsb)
- `status`: Status (`completed`, `pending`, `failed`, `paid`, `overdue`, `partial`)
- `description`: Keterangan tambahan
- `reference_number`: Nomor referensi pembayaran

---

## Sinkronisasi Bulk
- Untuk sinkronisasi massal, lakukan paginasi pada `/students`, `/payments`, dan `/receivables` hingga `last_page`.

---

## Endpoint Sinkronisasi via Controller (STEFIA)
- POST `/sync/start` body: `{ sync_type: students|payments|receivables|all, batch_size: int }`
- GET `/sync/status/{syncLog}` → status, progress, error log, dsb.

---

## Contoh Implementasi Dummy di Laravel
```php
if (App::environment(['local', 'testing'])) {
    return [
        'data' => [
            'payments' => [
                [
                    'payment_id' => 'DUMMY-PAY-001',
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'amount' => 1000000,
                    'payment_date' => '2024-01-01',
                    'payment_method' => 'bank_transfer',
                    'payment_type' => 'SPP',
                    'status' => 'completed',
                    'description' => 'Dummy payment',
                    'reference_number' => 'DUMMY-REF-001'
                ]
            ],
            'receivables' => [
                [
                    'receivable_id' => 'DUMMY-RCV-001',
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'fee_type' => 'SPP',
                    'amount' => 2000000,
                    'paid_amount' => 500000,
                    'outstanding_amount' => 1500000,
                    'due_date' => '2024-02-01',
                    'status' => 'partial',
                    'description' => 'Dummy receivable'
                ]
            ],
            'pagination' => [
                'current_page' => 1,
                'last_page' => 1
            ]
        ]
    ];
}
``` 