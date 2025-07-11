<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceivablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('receivables.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('receivables.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic untuk menyimpan piutang baru
        return redirect()->route('receivables.index')->with('success', 'Piutang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('receivables.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('receivables.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logic untuk mengupdate piutang
        return redirect()->route('receivables.index')->with('success', 'Piutang berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk menghapus piutang
        return redirect()->route('receivables.index')->with('success', 'Piutang berhasil dihapus');
    }

    /**
     * Display outstanding receivables.
     */
    public function outstanding()
    {
        return view('receivables.outstanding');
    }

    /**
     * Display receivables history.
     */
    public function history()
    {
        return view('receivables.history');
    }

    /**
     * Bulk update receivables status.
     */
    public function bulkUpdate(Request $request)
    {
        // Logic untuk bulk update status piutang
        return redirect()->back()->with('success', 'Status piutang berhasil diupdate');
    }
}
