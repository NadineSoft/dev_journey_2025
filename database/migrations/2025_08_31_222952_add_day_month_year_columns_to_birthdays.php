<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('birthdays', function (Blueprint $table) {
            $table->unsignedTinyInteger('day')->after('name');
            $table->unsignedTinyInteger('month')->after('day');
            $table->unsignedSmallInteger('year')->after('month')->nullable();
        });
        \App\Models\Birthday::whereNotNull('date')->chunk(100, function ($birthdays) {
            foreach ($birthdays as $birthday) {
                $c = \Carbon\Carbon::parse($birthday->date);
                $birthday->day = $c->day;
                $birthday->month = $c->month;
                $birthday->year = $c->year;
                $birthday->save();
            }
        });
        Schema::table('birthdays', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('birthdays', function (Blueprint $table) {
            //
        });
    }
};
