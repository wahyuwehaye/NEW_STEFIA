<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncStudentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:students 
                            {--batch-size=100 : Number of students to process in each batch}
                            {--force : Force sync even if last sync was recent}
                            {--nim= : Sync specific student by NIM}';

    /**
     * The console command description.
     */
    protected $description = 'Sync students data from iGracias API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting student synchronization...');

        $batchSize = $this->option('batch-size');
        $force = $this->option('force');
        $nim = $this->option('nim');

        try {
            $service = new \App\Services\IGraciasApiService();
            $syncLog = \App\Models\SyncLog::createNew('students');

            $syncLog->markAsProcessing();

            if ($nim) {
                // Sync specific student
                $this->info("Syncing student with NIM: {$nim}");
                $result = $service->syncStudent($nim);
                
                if ($result) {
                    $this->info("Student {$nim} synced successfully.");
                    $syncLog->updateProgress(1, 1);
                } else {
                    $this->error("Failed to sync student {$nim}");
                    $syncLog->incrementFailedRecords();
                }
            } else {
                // Sync all students
                $this->info('Fetching all students from iGracias...');
                $students = $service->getAllStudents();
                
                $totalStudents = count($students);
                $syncLog->updateProgress(0, $totalStudents);
                
                $this->info("Found {$totalStudents} students to sync.");
                
                $progressBar = $this->output->createProgressBar($totalStudents);
                $progressBar->start();
                
                $processed = 0;
                $failed = 0;
                
                foreach (array_chunk($students, $batchSize) as $batch) {
                    foreach ($batch as $studentData) {
                        try {
                            $student = $service->updateLocalStudent($studentData);
                            $processed++;
                            
                            $progressBar->advance();
                            $syncLog->updateProgress($processed);
                            
                        } catch (\Exception $e) {
                            $failed++;
                            $syncLog->incrementFailedRecords();
                            $syncLog->addError('Failed to sync student: ' . $e->getMessage(), [
                                'nim' => $studentData['nim'] ?? 'unknown',
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
                
                $progressBar->finish();
                $this->newLine();
            }

            $syncLog->markAsCompleted();
            $this->info('Student synchronization completed successfully.');
            $this->info("Processed: {$syncLog->processed_records}");
            $this->info("Failed: {$syncLog->failed_records}");
            
        } catch (\Exception $e) {
            $this->error('Synchronization failed: ' . $e->getMessage());
            if (isset($syncLog)) {
                $syncLog->markAsFailed([$e->getMessage()]);
            }
            return 1;
        }

        return 0;
    }
}
