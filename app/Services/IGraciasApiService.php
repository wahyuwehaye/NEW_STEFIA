<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Student;
use App\Models\SyncLog;

class IGraciasApiService
{
    private $baseUrl;
    private $accessToken;
    
    public function __construct()
    {
        $this->baseUrl = config('services.igracias.base_url');
        $this->accessToken = $this->getAccessToken();
    }
    
    public function getStudents(array $filters = [])
    {
        $response = Http::withToken($this->accessToken)
            ->get("{$this->baseUrl}/students", $filters);
            
        if ($response->successful()) {
            return $response->json();
        }
        
        throw new \Exception('Failed to fetch students: ' . $response->body());
    }
    
    public function syncStudent($nim)
    {
        $response = Http::withToken($this->accessToken)
            ->get("{$this->baseUrl}/students/{$nim}");
            
        if ($response->successful()) {
            $studentData = $response->json()['data'];
            return $this->updateLocalStudent($studentData);
        }
        
        return false;
    }

    public function getAllStudents()
    {
        $allStudents = [];
        $page = 1;
        $perPage = config('services.igracias.sync_per_page', 100);
        
        do {
            $response = $this->getStudents([
                'page' => $page,
                'per_page' => $perPage
            ]);
            
            $students = $response['data']['students'];
            $allStudents = array_merge($allStudents, $students);
            
            $pagination = $response['data']['pagination'];
            $page++;
        } while ($page <= $pagination['last_page']);
        
        return $allStudents;
    }
    
    private function getAccessToken()
    {
        return Cache::remember('igracias_token', 3500, function () {
            $response = Http::post("{$this->baseUrl}/auth/login", [
                'username' => config('services.igracias.username'),
                'password' => config('services.igracias.password'),
                'client_id' => config('services.igracias.client_id'),
                'client_secret' => config('services.igracias.client_secret'),
            ]);
            
            return $response->json()['data']['access_token'];
        });
    }

    private function updateLocalStudent(array $data)
    {
        return Student::updateOrCreate(
            ['nim' => $data['nim']],
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'birth_place' => $data['birth_place'],
                'birth_date' => $data['birth_date'],
                'faculty' => $data['faculty'],
                'department' => $data['department'],
                'cohort_year' => $data['cohort_year'],
                'current_semester' => $data['current_semester'],
                'status' => $data['status'],
                'total_fee' => $data['total_outstanding'],
                'outstanding_semesters' => $data['outstanding_semesters'],
                'last_payment_date' => $data['last_payment_date'],
                'is_reminded' => $data['is_reminded'],
                'external_id' => $data['external_id'],
                // Add more fields as required
            ]
        );
    }
}

