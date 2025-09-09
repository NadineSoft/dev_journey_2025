<?php

namespace App\Http\Controllers;

use App\Services\BirthdayExporter;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function csv(BirthdayExporter $exp)
    {
        $csv = $exp->toCsv(auth()->id());
        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="birthdays.csv"',
        ]);
    }

    public function ics(BirthdayExporter $exp)
    {
        $ics = $exp->toIcs(auth()->id());
        return response($ics, 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="birthdays.ics"',
        ]);
    }
}
