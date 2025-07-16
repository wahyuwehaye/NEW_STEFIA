<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Imports\StudentsImport;
use App\Models\Student;
use App\Models\ParentModel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentsImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_parse_rupiah_values()
    {
        $import = new StudentsImport();
        
        // Test dengan reflection untuk mengakses method private
        $reflection = new \ReflectionClass($import);
        $parseRupiah = $reflection->getMethod('parseRupiah');
        $parseRupiah->setAccessible(true);
        
        // Test berbagai format rupiah
        $this->assertEquals(5000000, $parseRupiah->invoke($import, 'Rp 5.000.000'));
        $this->assertEquals(2500000, $parseRupiah->invoke($import, '2500000'));
        $this->assertEquals(1000000, $parseRupiah->invoke($import, 'Rp 1,000,000'));
        $this->assertEquals(0, $parseRupiah->invoke($import, ''));
        $this->assertEquals(0, $parseRupiah->invoke($import, 'invalid'));
    }

    public function test_validation_rules_are_correct()
    {
        $import = new StudentsImport();
        $rules = $import->rules();
        
        $this->assertArrayHasKey('nim', $rules);
        $this->assertArrayHasKey('nama', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('fakultas', $rules);
        $this->assertArrayHasKey('program_studi', $rules);
        
        $this->assertStringContainsString('required', $rules['nim']);
        $this->assertStringContainsString('unique:students,nim', $rules['nim']);
        $this->assertStringContainsString('required', $rules['nama']);
        $this->assertStringContainsString('required', $rules['email']);
        $this->assertStringContainsString('unique:students,email', $rules['email']);
    }

    public function test_can_get_stats()
    {
        $import = new StudentsImport();
        $stats = $import->getStats();
        
        $this->assertArrayHasKey('total_rows', $stats);
        $this->assertArrayHasKey('successful', $stats);
        $this->assertArrayHasKey('failed', $stats);
        $this->assertArrayHasKey('errors', $stats);
        
        $this->assertEquals(0, $stats['total_rows']);
        $this->assertEquals(0, $stats['successful']);
        $this->assertEquals(0, $stats['failed']);
        $this->assertIsArray($stats['errors']);
    }

    public function test_batch_and_chunk_sizes()
    {
        $import = new StudentsImport();
        
        $this->assertEquals(100, $import->batchSize());
        $this->assertEquals(100, $import->chunkSize());
        $this->assertEquals(2, $import->startRow());
    }

    public function test_custom_validation_messages()
    {
        $import = new StudentsImport();
        $messages = $import->customValidationMessages();
        
        $this->assertArrayHasKey('nim.required', $messages);
        $this->assertArrayHasKey('nim.unique', $messages);
        $this->assertArrayHasKey('nama.required', $messages);
        $this->assertArrayHasKey('email.required', $messages);
        $this->assertArrayHasKey('email.unique', $messages);
        
        $this->assertEquals('NIM harus diisi.', $messages['nim.required']);
        $this->assertEquals('NIM sudah ada dalam database.', $messages['nim.unique']);
    }
}
