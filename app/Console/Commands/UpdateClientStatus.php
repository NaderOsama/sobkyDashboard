<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class UpdateClientStatus extends Command
{

    protected $signature = 'clients:update-status';

    protected $description = 'Update clients status based on their subscriptions';

    public function handle()
    {
        $subscriptions = Subscription::all();
        foreach ($subscriptions as $subscription) {
            $subscription->updateClientStatus();
        }

        $this->info('Client statuses updated successfully.');
    }
}
 