<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class GolferController extends Controller
{
    /**
     * List every golfer and their roles, for the pro shop staff screen.
     */
    public function index(): Response
    {
        return Inertia::render('Golfers/Index', [
            'golfers' => User::with('roles')->orderBy('name')->get(),
            'roles' => Role::orderBy('name')->get(),
        ]);
    }
}
