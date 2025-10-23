<?php

namespace App\Jobs;

use App\Mail\WeeklyBirthdaysMail;
use App\Models\User;
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

    public int $tries = 3;
    public int $timeout = 50;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public $userId,
        public $birthdayIds
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $user = User::find($this->userId);
        $birthdays = Birthday::whereIn('id', $this->birthdayIds)->get();
        try {
            Mail::to($user->email)->send(new WeeklyBirthdaysMail($user->name, $birthdays));
            Log::info('Email sent successfully!');
        } catch (\Exception $e) {
            Log::error('Eroare la trimitere email: ' . $e->getMessage());
            dd($e->getMessage()); // Pentru debug în terminal
        }
    }
}
