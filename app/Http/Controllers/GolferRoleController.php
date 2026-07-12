<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GolferRoleController extends Controller
{
    /**
     * Assign a role to a golfer by attaching the model itself.
     */
    public function store(Request $request, User $golfer): RedirectResponse
    {
        $role = Role::findOrFail((int) $request->validate([
            'role_id' => ['required', 'exists:roles,id'],
        ])['role_id']);

        $golfer->roles()->attach($role, ['assigned_at' => now()]);

        return back()->with('status', "Assigned the {$role->name} role.");
    }

    /**
     * Renew a role assignment by updating the pivot directly.
     */
    public function update(User $golfer, Role $role): RedirectResponse
    {
        $golfer->roles()->updateExistingPivot($role, [
            'assigned_at' => now(),
        ]);

        return back()->with('status', "Renewed the {$role->name} role.");
    }
}
