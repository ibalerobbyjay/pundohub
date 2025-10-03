<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    // Show all members
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    // Show create form
    public function create()
    {
        return view('members.create');
    }

    // Store new member
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'contact' => 'nullable|string',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    // Show member details
    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    // Show edit form
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    // Update member
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    // Delete member
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
