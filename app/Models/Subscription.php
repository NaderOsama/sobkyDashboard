<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Package;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'start_at',
        'initial_send_check_in',
        'payment_method',
        'transaction_number',
        'transaction_date',
        'from_phone',
        'to_phone',
        'transaction_type',
        'notes',
        'client_id',
    ];
    protected $dates = [
        'start_at', 
    ];


    public static function boot()
    {
        parent::boot();

        // Registering model events
        static::created(function ($subscription) {
            $subscription->updateClientStatus();
        });

        static::updated(function ($subscription) {
            $subscription->updateClientStatus();
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Method to update client status based on subscription start date and package duration

    public function updateClientStatus()
    {
        $client = $this->client;

        if (!$client) {
            return; // Handle if the client doesn't exist
        }

        // Check if the subscription start date is before or equal to the current date
        if ($this->start_at->isToday() || $this->start_at < Carbon::now()) {
            // Calculate the end date based on the start date and package duration
            $endDate = $this->start_at->addMonths($this->package->getDurationInMonthsAttribute());

            // Check if the end date is in the past or equals the current date
            if ($endDate <= Carbon::now()) {
                // Subscription has expired
                $client->update(['status' => 'expired']);
            } else {
                // Subscription is active
                $client->update(['status' => 'subscribed']);
            }
        } else
        {
            // Subscription has not started yet
            $client->update(['status' => 'not subscribed']);
        }
    }

}
