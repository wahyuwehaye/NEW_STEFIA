<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserManagementService;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
        
        // Apply role middleware
        $this->middleware('role:super_admin,admin')->except(['show']);
        $this->middleware('role:super_admin')->only(['destroy', 'roles']);
    }

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['role', 'status', 'search']);
        $users = $this->userService->getUsersWithFilters($filters);
        $roles = $this->userService->getUserRoles();
        
        return view('users.index', compact('users', 'roles', 'filters'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = $this->userService->getUserRoles();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            
            $message = $user->is_active ? 'User berhasil ditambahkan' : 'User berhasil ditambahkan dan menunggu persetujuan';
            
            return redirect()->route('users.index')->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $activityLogs = $this->userService->getUserActivityLogs($user, 50);
        return view('users.show', compact('user', 'activityLogs'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $roles = $this->userService->getUserRoles();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            
            // Hash password if provided
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data['password']);
            }
            
            $this->userService->updateUser($user, $data);
            
            return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupdate user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
            }
            
            $this->userService->deleteUser($user);
            
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

    /**
     * Display roles and permissions management.
     */
    public function roles()
    {
        $roles = $this->userService->getUserRoles();
        $users = User::all();
        
        return view('users.roles', compact('roles', 'users'));
    }

    /**
     * Display user approval page.
     */
    public function approval()
    {
        $pendingRequests = $this->userService->getPendingApprovals();
        
        return view('users.approval', compact('pendingRequests'));
    }

    /**
     * Display user audit log.
     */
    public function audit()
    {
        $activityLogs = $this->userService->getUserActivityLogs(null, 200);
        
        return view('users.audit', compact('activityLogs'));
    }

    /**
     * Approve a user.
     */
    public function approve(Request $request, User $user)
    {
        try {
            $this->userService->approveUser($user, $request->input('notes'));
            
            return redirect()->route('users.approval')->with('success', 'User berhasil diapprove');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal approve user: ' . $e->getMessage());
        }
    }

    /**
     * Reject a user.
     */
    public function reject(Request $request, User $user)
    {
        try {
            $this->userService->rejectUser($user, $request->input('notes'));
            
            return redirect()->route('users.approval')->with('success', 'User berhasil direject');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal reject user: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleStatus(User $user)
    {
        try {
            $user->update(['is_active' => !$user->is_active]);
            
            $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect()->back()->with('success', "User berhasil {$status}");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengubah status user: ' . $e->getMessage());
        }
    }
}
