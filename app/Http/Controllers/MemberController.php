<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    // List all members (users with role 'member')
    public function index()
    {
        $members = User::where('role', 'member')->get();
        return view('members.index', compact('members'));
    }

    // Show create form
    public function create()
    {
        return view('members.create');
    }

    // Store new member (as user)
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'household'=> 'nullable|string',
            'contact'  => 'nullable|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'household'=> $request->household,
            'contact'  => $request->contact,
            'role'     => 'member', // identify as member
        ]);

        return redirect()->route('members.index')
                         ->with('success', 'Member created successfully and can now log in.');
    }

    // Show a single member
    public function show(User $member)
    {
        return view('members.show', compact('member'));
    }

    // Edit member
    public function edit(User $member)
    {
        return view('members.edit', compact('member'));
    }

    // Update member info
    public function update(Request $request, User $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'household' => 'nullable|string',
            'contact' => 'nullable|string',
        ]);

        $member->update($request->only(['name', 'household', 'contact']));

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    // Delete member
    public function destroy(User $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
