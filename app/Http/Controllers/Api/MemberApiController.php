<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberApiController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();
        return response()->json($members);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email',
            'household' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'is_verified' => 'boolean'
        ]);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:members,email,' . $member->id,
            'household' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'is_verified' => 'boolean'
        ]);

        $member->update($validated);

        return response()->json($member);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return response()->json(['message' => 'Member deleted successfully']);
    }
}
