<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

uses(TestCase::class, RefreshDatabase::class);

it('allows authenticated user to pass through middleware', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'is_approved' => true,
    ]);
    
    $response = $this->actingAs($user)
                     ->get('/dashboard');
    
    expect($response->status())->toBe(200);
});

it('redirects unauthenticated user to login', function () {
    $response = $this->get('/dashboard');
    
    expect($response->status())->toBe(302);
    expect($response->getTargetUrl())->toContain('/login');
});

it('handles session timeout correctly', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'is_approved' => true,
    ]);
    
    // Simulate expired session by setting last activity to past
    $this->actingAs($user);
    
    session(['last_activity' => time() - (config('session.lifetime') * 60 + 100)]);
    
    $response = $this->get('/dashboard');
    
    expect($response->status())->toBe(302);
    expect($response->getTargetUrl())->toContain('/login');
});

it('extends session when user is active', function () {
    $user = User::factory()->create([
        'role' => 'admin',
        'is_active' => true,
        'is_approved' => true,
    ]);
    
    $response = $this->actingAs($user)
                     ->post('/api/extend-session');
    
    expect($response->status())->toBe(200);
    expect($response->json('success'))->toBe(true);
    expect(session('last_activity'))->toBeGreaterThan(time() - 5);
});

it('returns json response for ajax timeout requests', function () {
    session(['last_activity' => time() - (config('session.lifetime') * 60 + 100)]);
    
    $response = $this->getJson('/dashboard');
    
    expect($response->status())->toBe(401);
    expect($response->json('message'))->toContain('Session expired');
});
