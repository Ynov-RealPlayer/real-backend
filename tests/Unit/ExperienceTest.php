<?php

use Faker\Factory;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Utils\ExperienceController;

uses(RefreshDatabase::class);
uses(TestCase::class);

test('function give experience', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience + 10;
    ExperienceController::giveExperience($user, 10);
    expect($user->experience)->toBe($experienceExpected);
});

test('function give experience with negative number', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience - 10;
    ExperienceController::giveExperience($user, -10);
    expect($user->experience)->toBe($experienceExpected);
});

test('function give experience with string', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience + 10;
    ExperienceController::giveExperience($user, '10');
    expect($user->experience)->toBe($experienceExpected);
});

test('function give experience with string negative', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience - 10;
    ExperienceController::giveExperience($user, '-10');
    expect($user->experience)->toBe($experienceExpected);
});

test('function give experience with float', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience + 10;
    ExperienceController::giveExperience($user, 10.5);
    expect($user->experience)->toBe($experienceExpected);
});

test('function give experience with float negative', function () {
    $user = User::factory()->create();
    $experience = $user->experience;
    $experienceExpected = $experience - 10;
    ExperienceController::giveExperience($user, -10.5);
    expect($user->experience)->toBe($experienceExpected);
});
