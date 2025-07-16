<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Fee;
use App\Models\Receivable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class SimpleApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_api_health_check_returns_success()
    {
        $response = $this->getJson('/api/health');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'timestamp'
                 ]);
    }

    public function test_students_api_requires_authentication()
    {
        $response = $this->getJson('/api/v1/students');
        $response->assertStatus(401);
    }

    public function test_students_api_returns_data_when_authenticated()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data'
                 ]);
    }

    public function test_dashboard_statistics_returns_data()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/dashboard/statistics');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'total_students',
                         'total_payments',
                         'total_receivables'
                     ]
                 ]);
    }
}
