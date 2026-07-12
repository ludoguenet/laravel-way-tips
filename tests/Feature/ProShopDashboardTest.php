<?php

use App\Models\Role;
use App\Models\User;

test('staff can view the pro shop dashboard', function () {
    $marshal = User::factory()->create();
    $marshal->roles()->attach(Role::factory()->create(['name' => 'marshal']));

    $this->actingAs($marshal)->get(route('pro-shop.index'))->assertOk();
});

test('a golfer without a staff role is forbidden', function () {
    $golfer = User::factory()->create();

    $this->actingAs($golfer)->get(route('pro-shop.index'))->assertForbidden();
});

test('the legacy dashboard route enforces the same rule', function () {
    $marshal = User::factory()->create();
    $marshal->roles()->attach(Role::factory()->create(['name' => 'marshal']));
    $golfer = User::factory()->create();

    $this->actingAs($marshal)->get(route('pro-shop.index-legacy'))->assertOk();
    $this->actingAs($golfer)->get(route('pro-shop.index-legacy'))->assertForbidden();
});
