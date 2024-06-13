<?php

namespace App\Console\Commands;

use App\Models\ClientCheckIn;
use Illuminate\Console\Command;

class UpdateRemainingDays extends Command
{
    protected $signature = 'update:remaining-days';
    protected $description = 'Update remaining days for client check-ins';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all client check-ins
        $clientCheckIns = ClientCheckIn::all();

        foreach ($clientCheckIns as $clientCheckIn) {
            foreach ($clientCheckIn->formAnswers as $formAnswer) {
                // Update remaining days
                $remainingDays = $formAnswer->remaining_days;
                    // Update remaining days only if it is not null
                    if ($formAnswer->remaining_days !== null) {
                        $remainingDays = $formAnswer->remaining_days;

                        $formAnswer->update([
                            'remaining_days' => $remainingDays - 1
                        ]);
                    }
            }
        }

        $this->info('Remaining days updated successfully.');
    }
}

