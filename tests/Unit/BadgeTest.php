<?php

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use App\Models\Badge;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Utils\BadgeController;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
uses(TestCase::class);

test('function give badge to user', function () {
    $user = User::factory()->create();
    $badge = Badge::factory()->create();
    BadgeController::store($badge, $user);
    expect($user->badges->count())->toBe(1);
});