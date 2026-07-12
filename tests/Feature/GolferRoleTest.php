<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;

test('a role can be attached to a golfer by model', function () {
    $golfer = User::factory()->create();
    $role = Role::factory()->create(['name' => 'marshal']);

    $this->actingAs($golfer)
        ->post(route('golfers.roles.store', $golfer), ['role_id' => $role->id])
        ->assertRedirect();

    expect($golfer->roles()->where('roles.id', $role->id)->exists())->toBeTrue();
});

test('the legacy store route attaches an equivalent role', function () {
    $golfer = User::factory()->create();
    $role = Role::factory()->create(['name' => 'pro-shop']);

    $this->actingAs($golfer)
        ->post(route('golfers.roles.store-legacy', $golfer), ['role_id' => $role->id])
        ->assertRedirect();

    expect($golfer->roles()->where('roles.id', $role->id)->exists())->toBeTrue();
});

test('a role assignment can be renewed via updateExistingPivot', function () {
    $golfer = User::factory()->create();
    $role = Role::factory()->create(['name' => 'marshal']);
    $golfer->roles()->attach($role, ['assigned_at' => now()->subYear()]);

    $this->actingAs($golfer)
        ->patch(route('golfers.roles.update', [$golfer, $role]))
        ->assertRedirect();

    $assignedAt = $golfer->roles()->where('roles.id', $role->id)->first()->pivot->assigned_at;
    expect(Carbon::parse($assignedAt)->isToday())->toBeTrue();
});

test('the legacy update route renews an equivalent role assignment', function () {
    $golfer = User::factory()->create();
    $role = Role::factory()->create(['name' => 'marshal']);
    $golfer->roles()->attach($role, ['assigned_at' => now()->subYear()]);

    $this->actingAs($golfer)
        ->patch(route('golfers.roles.update-legacy', [$golfer, $role]))
        ->assertRedirect();

    $assignedAt = $golfer->roles()->where('roles.id', $role->id)->first()->pivot->assigned_at;
    expect(Carbon::parse($assignedAt)->isToday())->toBeTrue();
});
