<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Paired with GolferRoleController for the golf-app tutorial series —
 * see the "Attach models, not IDs" and "updateExistingPivot" tips.
 */
class LegacyGolferRoleController extends Controller
{
    /**
     * Assign a role to a golfer by attaching a raw pivot ID.
     */
    public function store(Request $request, User $golfer): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $golfer->roles()->attach($validated['role_id'], ['assigned_at' => now()]);

        return back()->with('status', 'Role assigned (the old way).');
    }

    /**
     * Renew a role assignment by querying and updating the pivot row directly.
     */
    public function update(User $golfer, Role $role): RedirectResponse
    {
        DB::table('role_user')
            ->where('user_id', $golfer->id)
            ->where('role_id', $role->id)
            ->update(['assigned_at' => now()]);

        return back()->with('status', 'Role renewed (the old way).');
    }
}
