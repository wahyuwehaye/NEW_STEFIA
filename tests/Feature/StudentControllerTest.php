<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\AcademicYear;
use App\Models\Major;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StudentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user with proper permissions
        $this->user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
            'is_approved' => true,
        ]);
        
        // Create test data
        $this->faculty = Faculty::create([
            'name' => 'Fakultas Teknik',
            'code' => 'FT',
            'description' => 'Fakultas Teknik',
        ]);
        
        $this->academicYear = AcademicYear::create([
            'year' => '2023/2024',
            'start_date' => '2023-08-01',
            'end_date' => '2024-07-31',
            'is_active' => true,
        ]);
        
        $this->major = Major::create([
            'name' => 'Teknik Informatika',
            'code' => 'TI',
            'faculty_id' => $this->faculty->id,
        ]);
    }

    public function test_can_access_students_index()
    {
        $response = $this->actingAs($this->user)->get('/students');
        $response->assertStatus(200);
    }

    public function test_can_download_template()
    {
        $response = $this->actingAs($this->user)->get('/students/download-template');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_can_access_analytics()
    {
        $response = $this->actingAs($this->user)->get('/students/analytics');
        $response->assertStatus(200);
    }

    public function test_can_access_bulk_operations()
    {
        $response = $this->actingAs($this->user)->get('/students/bulk-operations');
        $response->assertStatus(200);
    }

    public function test_can_export_students()
    {
        // Create a test student
        Student::create([
            'nim' => '20230001',
            'name' => 'Test Student',
            'email' => 'test@example.com',
            'faculty' => 'Fakultas Teknik',
            'program_study' => 'Teknik Informatika',
            'status' => 'active',
            'cohort_year' => '2023',
            'academic_year' => '2023/2024',
        ]);

        $response = $this->actingAs($this->user)->get('/students/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    public function test_can_access_api_endpoint()
    {
        $response = $this->actingAs($this->user)->get('/api/students');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'current_page',
            'per_page',
            'total'
        ]);
    }

    public function test_can_search_students()
    {
        // Create test students
        Student::create([
            'nim' => '20230001',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'faculty' => 'Fakultas Teknik',
            'program_study' => 'Teknik Informatika',
            'status' => 'active',
            'cohort_year' => '2023',
            'academic_year' => '2023/2024',
        ]);
        
        Student::create([
            'nim' => '20230002',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'faculty' => 'Fakultas Ekonomi',
            'program_study' => 'Manajemen',
            'status' => 'active',
            'cohort_year' => '2023',
            'academic_year' => '2023/2024',
        ]);

        $response = $this->actingAs($this->user)->get('/api/students?search=John');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'John Doe']);
    }

    public function test_can_filter_students_by_faculty()
    {
        // Create test students
        Student::create([
            'nim' => '20230001',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'faculty' => 'Fakultas Teknik',
            'program_study' => 'Teknik Informatika',
            'status' => 'active',
            'cohort_year' => '2023',
            'academic_year' => '2023/2024',
        ]);
        
        Student::create([
            'nim' => '20230002',
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'faculty' => 'Fakultas Ekonomi',
            'program_study' => 'Manajemen',
            'status' => 'active',
            'cohort_year' => '2023',
            'academic_year' => '2023/2024',
        ]);

        $response = $this->actingAs($this->user)->get('/api/students?faculty=Fakultas Teknik');
        $response->assertStatus(200);
        $response->assertJsonFragment(['faculty' => 'Fakultas Teknik']);
    }

    public function test_import_form_accessible()
    {
        $response = $this->actingAs($this->user)->get('/students/import-form');
        $response->assertStatus(200);
    }
}
