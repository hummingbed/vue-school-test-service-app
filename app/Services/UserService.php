<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $httpClient;
    protected $batchSize = 1000; // Max records per batch
    protected $maxBatches = 50;   // Max batches per hour
    protected $timezones = ['CET', 'CST', 'GMT+1']; // Sample timezones

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function updateUserAttributes()
    {
        $changedUsers = $this->getChangedUsers(); // Fetch users whose attributes have changed
        $batches = $this->prepareBatches($changedUsers);
        
        foreach ($batches as $batch) {
            $this->sendBatchRequest($batch);
            // Optional: Add a delay if you need to manage rate limiting
            sleep(3600 / $this->maxBatches); // Distribute calls evenly over the hour
        }
    }

    protected function getChangedUsers()
    {
        // Fetch users whose attributes have changed
        return DB::table('users')
            ->where('needs_update', true) // Assuming you have a flag for updates
            ->get();
    }

    protected function prepareBatches($users)
    {
        $batches = [];
        $currentBatch = [];

        foreach ($users as $user) {
            $currentBatch[] = [
                'email' => $user->email,
                'time_zone' => $user->timezone, // or any other attributes you need to update
                'name' => $user->name,
            ];

            if (count($currentBatch) >= $this->batchSize) {
                $batches[] = $currentBatch;
                $currentBatch = [];
            }
        }

        if (!empty($currentBatch)) {
            $batches[] = $currentBatch; // Add remaining users to a batch
        }

        return $batches;
    }

    protected function sendBatchRequest($batch)
    {
        $response = $this->httpClient->post('https://api.example.com/batch', [
            'json' => ['batches' => [['subscribers' => $batch]]],
        ]);

        // Handle the response (e.g., logging, error handling)
        if ($response->getStatusCode() !== 200) {
            // Handle error
        }
    }
}
