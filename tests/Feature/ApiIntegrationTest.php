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

class ApiIntegrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function test_students_api_index_requires_authentication()
    {
        $response = $this->getJson('/api/v1/students');
        $response->assertStatus(401);
    }

    /** @test */
    public function test_students_api_index_returns_students()
    {
        $user = User::factory()->create();
        $students = Student::factory(3)->create();
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'email',
                             'student_id',
                             'study_program',
                             'status',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function test_students_api_store_creates_new_student()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $studentData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'student_id' => $this->faker->unique()->numerify('########'),
            'study_program' => $this->faker->word,
            'status' => 'active'
        ];

        $response = $this->postJson('/api/v1/students', $studentData);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'name',
                         'email',
                         'student_id',
                         'study_program',
                         'status'
                     ]
                 ]);

        $this->assertDatabaseHas('students', [
            'email' => $studentData['email'],
            'student_id' => $studentData['student_id']
        ]);
    }

    /** @test */
    public function test_students_api_show_returns_single_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson("/api/v1/students/{$student->id}");
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $student->id,
                         'name' => $student->name,
                         'email' => $student->email,
                         'student_id' => $student->student_id
                     ]
                 ]);
    }

    /** @test */
    public function test_students_api_update_modifies_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        Sanctum::actingAs($user);
        
        $updateData = [
            'name' => 'Updated Name',
            'status' => 'inactive'
        ];

        $response = $this->putJson("/api/v1/students/{$student->id}", $updateData);
        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'id' => $student->id,
                         'name' => 'Updated Name',
                         'status' => 'inactive'
                     ]
                 ]);

        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'name' => 'Updated Name',
            'status' => 'inactive'
        ]);
    }

    /** @test */
    public function test_students_api_destroy_deletes_student()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        Sanctum::actingAs($user);
        
        $response = $this->deleteJson("/api/v1/students/{$student->id}");
        $response->assertStatus(204);

        $this->assertSoftDeleted('students', ['id' => $student->id]);
    }

    /** @test */
    public function test_students_api_financial_summary_returns_correct_data()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        // Create some payments and receivables for the student
        Payment::factory(2)->create(['student_id' => $student->id, 'amount' => 1000]);
        Receivable::factory(1)->create(['student_id' => $student->id, 'amount' => 500]);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson("/api/v1/students/{$student->id}/financial-summary");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'student_id',
                         'total_payments',
                         'total_receivables',
                         'outstanding_balance',
                         'payment_history',
                         'receivable_history'
                     ]
                 ]);
    }

    /** @test */
    public function test_students_api_outstanding_payments_returns_unpaid_amounts()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        // Create unpaid receivables
        Receivable::factory(2)->create([
            'student_id' => $student->id,
            'amount' => 1000,
            'status' => 'active'
        ]);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson("/api/v1/students/{$student->id}/outstanding-payments");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'student_id',
                         'outstanding_receivables',
                         'total_outstanding',
                         'overdue_count'
                     ]
                 ]);
    }

    /** @test */
    public function test_payments_api_index_returns_payments()
    {
        $user = User::factory()->create();
        $payments = Payment::factory(3)->create();
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/payments');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'student_id',
                             'amount',
                             'payment_date',
                             'status',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function test_payments_api_store_creates_new_payment()
    {
        $user = User::factory()->create();
        $student = Student::factory()->create();
        
        Sanctum::actingAs($user);
        
        $paymentData = [
            'student_id' => $student->id,
            'amount' => 1500.50,
            'payment_date' => now()->toDateString(),
            'status' => 'completed',
            'payment_method' => 'transfer'
        ];

        $response = $this->postJson('/api/v1/payments', $paymentData);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'student_id',
                         'amount',
                         'payment_date',
                         'status'
                     ]
                 ]);

        $this->assertDatabaseHas('payments', [
            'student_id' => $student->id,
            'amount' => 1500.50,
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function test_fees_api_index_returns_fees()
    {
        $user = User::factory()->create();
        $fees = Fee::factory(3)->create();
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/fees');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'name',
                             'amount',
                             'type',
                             'status',
                             'created_at',
                             'updated_at'
                         ]
                     ]
                 ]);
    }

    /** @test */
    public function test_fees_api_store_creates_new_fee()
    {
        $user = User::factory()->create();
        
        Sanctum::actingAs($user);
        
        $feeData = [
            'name' => 'Tuition Fee',
            'amount' => 2000.00,
            'type' => 'tuition',
            'status' => 'active',
            'description' => 'Monthly tuition fee'
        ];

        $response = $this->postJson('/api/v1/fees', $feeData);
        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'name',
                         'amount',
                         'type',
                         'status'
                     ]
                 ]);

        $this->assertDatabaseHas('fees', [
            'name' => 'Tuition Fee',
            'amount' => 2000.00,
            'type' => 'tuition'
        ]);
    }

    /** @test */
    public function test_dashboard_statistics_api_returns_correct_data()
    {
        $user = User::factory()->create();
        
        // Create test data
        Student::factory(10)->create();
        Payment::factory(5)->create(['status' => 'completed']);
        Receivable::factory(3)->create(['status' => 'active']);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/dashboard/statistics');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         'total_students',
                         'total_payments',
                         'total_receivables',
                         'active_receivables',
                         'completed_payments',
                         'monthly_revenue',
                         'collection_rate'
                     ]
                 ]);
    }

    /** @test */
    public function test_api_health_check_returns_success()
    {
        $response = $this->getJson('/api/health');
        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'healthy',
                     'timestamp' => now()->toISOString()
                 ]);
    }

    /** @test */
    public function test_api_validation_errors_are_returned_properly()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        // Test invalid student creation
        $response = $this->postJson('/api/v1/students', [
            'name' => '', // Required field
            'email' => 'invalid-email', // Invalid email
            'student_id' => '', // Required field
        ]);
        
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'student_id']);
    }

    /** @test */
    public function test_api_pagination_works_correctly()
    {
        $user = User::factory()->create();
        Student::factory(25)->create(); // Create more than default pagination limit
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students?page=1&per_page=10');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data',
                     'meta' => [
                         'current_page',
                         'per_page',
                         'total',
                         'last_page'
                     ]
                 ]);
    }

    /** @test */
    public function test_api_filtering_works_correctly()
    {
        $user = User::factory()->create();
        $activeStudent = Student::factory()->create(['status' => 'active']);
        $inactiveStudent = Student::factory()->create(['status' => 'inactive']);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students?status=active');
        $response->assertStatus(200);
        
        $responseData = $response->json();
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals('active', $responseData['data'][0]['status']);
    }

    /** @test */
    public function test_api_sorting_works_correctly()
    {
        $user = User::factory()->create();
        $student1 = Student::factory()->create(['name' => 'Alice']);
        $student2 = Student::factory()->create(['name' => 'Bob']);
        $student3 = Student::factory()->create(['name' => 'Charlie']);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students?sort=name&order=desc');
        $response->assertStatus(200);
        
        $responseData = $response->json();
        $this->assertEquals('Charlie', $responseData['data'][0]['name']);
        $this->assertEquals('Bob', $responseData['data'][1]['name']);
        $this->assertEquals('Alice', $responseData['data'][2]['name']);
    }

    /** @test */
    public function test_api_rate_limiting_works()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        // Make multiple requests to test rate limiting
        for ($i = 0; $i < 65; $i++) {
            $response = $this->getJson('/api/v1/students');
            if ($i < 60) {
                $response->assertStatus(200);
            } else {
                $response->assertStatus(429); // Too Many Requests
                break;
            }
        }
    }

    /** @test */
    public function test_api_search_functionality_works()
    {
        $user = User::factory()->create();
        $student1 = Student::factory()->create(['name' => 'John Doe']);
        $student2 = Student::factory()->create(['name' => 'Jane Smith']);
        
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students?search=John');
        $response->assertStatus(200);
        
        $responseData = $response->json();
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals('John Doe', $responseData['data'][0]['name']);
    }

    /** @test */
    public function test_api_error_handling_for_not_found_resources()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        
        $response = $this->getJson('/api/v1/students/99999');
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Student not found'
                 ]);
    }

    /** @test */
    public function test_api_bulk_operations_work()
    {
        $user = User::factory()->create();
        $students = Student::factory(3)->create();
        
        Sanctum::actingAs($user);
        
        $studentIds = $students->pluck('id')->toArray();
        
        $response = $this->postJson('/api/v1/students/bulk-update', [
            'student_ids' => $studentIds,
            'status' => 'inactive'
        ]);
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'updated_count'
                 ]);
        
        foreach ($students as $student) {
            $this->assertDatabaseHas('students', [
                'id' => $student->id,
                'status' => 'inactive'
            ]);
        }
    }
}
