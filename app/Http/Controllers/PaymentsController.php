<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::with('student')->orderBy('payment_date', 'desc')->get();
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('payments.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_type' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);
        $payment = new Payment();
        $payment->student_id = $validated['student_id'];
        $payment->amount = $validated['amount'];
        $payment->payment_date = $validated['payment_date'];
        $payment->payment_method = $validated['payment_method'];
        $payment->payment_type = $validated['payment_type'] ?? null;
        $payment->description = $validated['description'] ?? null;
        $payment->notes = $validated['notes'] ?? null;
        $payment->status = 'completed';
        $payment->save();
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $payment = Payment::with('student')->findOrFail($id);
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail($id);
        $students = Student::orderBy('name')->get();
        return view('payments.edit', compact('payment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payment = Payment::findOrFail($id);
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|max:50',
            'payment_type' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);
        $payment->student_id = $validated['student_id'];
        $payment->amount = $validated['amount'];
        $payment->payment_date = $validated['payment_date'];
        $payment->payment_method = $validated['payment_method'];
        $payment->payment_type = $validated['payment_type'] ?? null;
        $payment->description = $validated['description'] ?? null;
        $payment->notes = $validated['notes'] ?? null;
        $payment->save();
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Pembayaran berhasil dihapus');
    }

    /**
     * Display pending payments.
     */
    public function pending()
    {
        $payments = Payment::pending()->with('student')->orderBy('payment_date', 'desc')->get();
        return view('payments.pending', compact('payments'));
    }

    /**
     * Display payment history.
     */
    public function history()
    {
        $payments = Payment::with('student')->orderBy('payment_date', 'desc')->get();
        return view('payments.history', compact('payments'));
    }

    /**
     * Display payment verification page.
     */
    public function verification()
    {
        return view('payments.verification');
    }

    /**
     * Display payment integration page.
     */
    public function integration()
    {
        return view('payments.integration');
    }

    /**
     * Verify a payment.
     */
    public function verify(Request $request, string $id)
    {
        // Logic untuk verifikasi pembayaran
        return redirect()->route('payments.verification')->with('success', 'Pembayaran berhasil diverifikasi');
    }

    /**
     * Sync payments with iGracias.
     */
    public function syncIgracias(Request $request)
    {
        // Logic untuk sinkronisasi dengan iGracias
        return redirect()->route('payments.integration')->with('success', 'Sinkronisasi dengan iGracias berhasil');
    }
}
