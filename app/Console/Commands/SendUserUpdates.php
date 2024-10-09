<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SendUserUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-user-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = DB::table('users')->where('needs_update', true)->get();

        if ($users->isEmpty()) {
            $this->info('No updates to send.');
            return;
        }

        $batches = $users->chunk(1000);

        foreach ($batches as $batch) {
            $this->sendBatch($batch);
        }

        $this->info('All updates sent successfully.');
    }

    protected function sendBatch($batch) {
       
        $subscribers = $batch->map(function ($user) {
            return [
                'email' => $user->email,
                'time_zone' => $user->timezone,
            ];
        })->toArray();

        // Send the batch request to the API
        $response = Http::get('https://randomapi.com/api/6de6abfedb24f889e0b5f675edc50deb', [
            'fmt' => 'raw',
            'sole' => true,
            'data' => json_encode(['batches' => [['subscribers' => $subscribers]]]),
        ]);

        if ($response->successful()) {
            DB::table('users')->whereIn('id', $batch->pluck('id'))->update(['needs_update' => false]);
            $this->info('Batch sent successfully.');
        } else {
            $this->error('Error sending batch: ' . $response->body());
        }
    }
}
