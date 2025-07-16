<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'payment_date' => 'required|date|before_or_equal:today',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,debit_card,e_wallet,other',
            'payment_type' => 'required|in:tuition,registration,exam,library,laboratory,other',
            'reference_number' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'student_id.required' => 'Siswa wajib dipilih',
            'student_id.exists' => 'Siswa tidak ditemukan',
            'amount.required' => 'Jumlah pembayaran wajib diisi',
            'amount.numeric' => 'Jumlah pembayaran harus berupa angka',
            'amount.min' => 'Jumlah pembayaran minimal Rp 0.01',
            'amount.max' => 'Jumlah pembayaran maksimal Rp 999,999,999.99',
            'payment_date.required' => 'Tanggal pembayaran wajib diisi',
            'payment_date.before_or_equal' => 'Tanggal pembayaran tidak boleh di masa depan',
            'payment_method.required' => 'Metode pembayaran wajib dipilih',
            'payment_type.required' => 'Jenis pembayaran wajib dipilih',
        ];
    }

    /**
     * Get custom attributes for validator errors
     */
    public function attributes(): array
    {
        return [
            'student_id' => 'siswa',
            'amount' => 'jumlah',
            'payment_date' => 'tanggal pembayaran',
            'payment_method' => 'metode pembayaran',
            'payment_type' => 'jenis pembayaran',
            'reference_number' => 'nomor referensi',
            'description' => 'deskripsi',
            'notes' => 'catatan',
        ];
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('amount')) {
            $this->merge([
                'amount' => str_replace(['Rp', '.', ' '], '', $this->amount)
            ]);
        }
    }
}
