<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
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
    
    public function getStudents(array $filters = [], $syncLog = null, $retry = 0)
    {
        // Dummy endpoint jika local/testing
        if (App::environment(['local', 'testing'])) {
            return [
                'data' => [
                    'students' => [
                        [
                            'nim' => 'DUMMY001',
                            'name' => 'Dummy Student',
                            'email' => 'dummy@student.ac.id',
                            'faculty' => 'Dummy Faculty',
                            'status' => 'active',
                        ]
                    ],
                    'pagination' => [
                        'current_page' => 1,
                        'last_page' => 1
                    ]
                ]
            ];
        }
        $maxRetry = 3;
        $backoff = [1, 2, 4];
        try {
            $response = Http::withToken($this->accessToken)
                ->timeout(15)
                ->get("{$this->baseUrl}/students", $filters);
            if ($response->successful()) {
                return $response->json();
            }
            // Log error to SyncLog
            if ($syncLog) {
                $syncLog->addError('Failed to fetch students', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'filters' => $filters
                ]);
            }
            if ($retry < $maxRetry) {
                sleep($backoff[$retry] ?? 2);
                return $this->getStudents($filters, $syncLog, $retry + 1);
            }
            throw new \Exception('Failed to fetch students after retry: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('IGraciasApiService getStudents error', ['error' => $e->getMessage(), 'filters' => $filters]);
            if ($syncLog) {
                $syncLog->addError($e->getMessage(), ['filters' => $filters]);
            }
            throw $e;
        }
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

    public function getAllStudents($syncLog = null)
    {
        // Dummy endpoint jika local/testing
        if (App::environment(['local', 'testing'])) {
            return [
                [
                    'nim' => 'DUMMY001',
                    'name' => 'Dummy Student',
                    'email' => 'dummy@student.ac.id',
                    'faculty' => 'Dummy Faculty',
                    'status' => 'active',
                ]
            ];
        }
        $allStudents = [];
        $page = 1;
        $perPage = config('services.igracias.sync_per_page', 100);
        $lastPage = 1;
        do {
            try {
                $response = $this->getStudents([
                    'page' => $page,
                    'per_page' => $perPage
                ], $syncLog);
                $students = $response['data']['students'] ?? [];
                $allStudents = array_merge($allStudents, $students);
                $pagination = $response['data']['pagination'] ?? ['last_page' => 1];
                $lastPage = $pagination['last_page'] ?? 1;
                if ($syncLog) {
                    $syncLog->updateProgress(count($allStudents), null);
                }
                $page++;
            } catch (\Exception $e) {
                if ($syncLog) {
                    $syncLog->addError($e->getMessage(), ['page' => $page]);
                }
                break;
            }
        } while ($page <= $lastPage);
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

