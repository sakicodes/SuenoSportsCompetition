<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllRegularUsers();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $this->userService->createUser($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    public function adjustPoints(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'amount' => 'required|integer', // Can be positive (funding) or negative (penalty)
            'description' => 'required|string|max:255',
        ]);

        $this->userService->adjustPoints($user, $validated['amount'], $validated['description']);

        return back()->with('success', "Successfully adjusted points for {$user->name}.");
    }
}
