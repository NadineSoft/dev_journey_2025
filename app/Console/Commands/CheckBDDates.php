<?php

namespace App\Console\Commands;

use App\Jobs\SendBirthdayEmail;
use App\Mail\WeeklyBirthdaysMail;
use App\Models\Birthday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckBDDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bd:check';

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
        //$bds = Birthday::whereBetween('date', [now(), now()->addDays(7)])->groupBy('user_id');

        $today = Carbon::now();
        $currentDay = $today->day;
        $currentMonth = $today->month;

        // Găsește zile de naștere de azi
        $todayBirthdays = Birthday::where('day', $currentDay)
            ->where('month', $currentMonth)
            ->with('user')
            ->get();


        $now = Carbon::now(); // Data curentă (ex: 2025-10-22)
        $end = $now->clone()->addDays(7); // Până la 2025-10-29

        // Scoate toate birthdays posibile (filtrează după luni posibile pentru eficiență)
        // Lunile posibile: luna curentă și următoarea (în caz că trece luna, ex: de la 28 dec la 4 ian)
        $possibleMonths = [$now->month];
        if ($end->month !== $now->month) {
            $possibleMonths[] = $end->month;
        }

        $birthdays = Birthday::whereIn('month', $possibleMonths)
            //->with('user') // Eager load user-ul pentru email
            ->with(['user' => function ($query) {
                $query->select('id', 'name', 'email'); // Doar astea 3; 'id' e obligatoriu pentru relație
            }])
            ->get();

//        $birthdays = $birthdays->map(function ($bd) {
//            $carbonDate = Carbon::createFromDate(null, $bd->month, 1); // Ziua 1 pentru validitate (nu contează)
//            $bd->monthName = $carbonDate->format('F'); // 'F' = nume lună full, ex: "October"
//            return $bd;
//        });

        // Filtrează în PHP doar cele upcoming în 7 zile
        $upcoming = $birthdays->filter(function ($birthday) use ($now, $end) {
            // Construiește data pentru anul curent
            try {
                $bdDate = Carbon::createFromDate($now->year, $birthday->month, $birthday->day);
            } catch (\Exception $e) {
                // Dacă day/month invalid (ex: 31 feb), skip
                Log::warning("Invalid birthday date: {$birthday->id}");
                return false;
            }

            // Dacă a trecut anul ăsta, mută la anul următor
            if ($bdDate->lt($now)) {
                $bdDate->addYear();
            }

            // Verifică dacă e în interval
            return $bdDate->gte($now) && $bdDate->lte($end);
        });

        // Grupează după user_id
        $grouped = $upcoming->groupBy('user_id');

        // Pentru fiecare grup (user), dispatch job-ul de email dacă user are email
        foreach ($grouped as $userId => $userBirthdays) {
            $user = $userBirthdays->first()->user; // Din eager load
            if ($user && $user->email) {
                SendBirthdayEmail::dispatch($user, $userBirthdays);
            }
        }
        $this->info('Checked birthdays and dispatched emails.');
    }
}
