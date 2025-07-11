<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Logic untuk menyimpan user baru
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        return view('users.show', compact('id'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        return view('users.edit', compact('id'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logic untuk mengupdate user
        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        // Logic untuk menghapus user
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }

    /**
     * Display roles and permissions management.
     */
    public function roles()
    {
        return view('users.roles');
    }

    /**
     * Display user approval page.
     */
    public function approval()
    {
        return view('users.approval');
    }

    /**
     * Display user audit log.
     */
    public function audit()
    {
        return view('users.audit');
    }

    /**
     * Approve a user.
     */
    public function approveUser(Request $request, $id)
    {
        // Logic untuk approve user
        return redirect()->route('users.approval')->with('success', 'User berhasil diapprove');
    }

    /**
     * Reject a user.
     */
    public function rejectUser(Request $request, $id)
    {
        // Logic untuk reject user
        return redirect()->route('users.approval')->with('success', 'User berhasil direject');
    }
}
