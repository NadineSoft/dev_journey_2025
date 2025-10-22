<?php

namespace App\Jobs;

use App\Mail\WeeklyBirthdaysMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Birthday;
use Carbon\Carbon;

class SendBirthdayEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $user,
        public $birthdays
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Mail::to($this->user->email)->send(new WeeklyBirthdaysMail($this->user->name, $this->birthdays));
            Log::info('Email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Eroare la trimitere email: ' . $e->getMessage());
            dd($e->getMessage()); // Pentru debug în terminal
        }
    }
}
