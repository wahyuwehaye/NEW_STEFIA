<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female',
            'class' => 'nullable|string|max:100',
            'program_study' => 'nullable|string|max:100',
            'academic_year' => 'required|string|max:20',
            'status' => 'nullable|in:active,inactive,graduated,dropped_out',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:20',
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama siswa wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini',
            'academic_year.required' => 'Tahun ajaran wajib diisi',
        ];
    }

    /**
     * Get custom attributes for validator errors
     */
    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'telepon',
            'address' => 'alamat',
            'birth_date' => 'tanggal lahir',
            'gender' => 'jenis kelamin',
            'class' => 'kelas',
            'program_study' => 'program studi',
            'academic_year' => 'tahun ajaran',
            'parent_name' => 'nama orang tua',
            'parent_phone' => 'telepon orang tua',
        ];
    }
}
