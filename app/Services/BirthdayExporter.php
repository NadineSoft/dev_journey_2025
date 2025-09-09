<?php

namespace App\Services;

use App\Models\Birthday;
use Illuminate\Support\Facades\Storage;


class BirthdayExporter
{
    public function toCsv($userId)
    {
        $rows = Birthday::where('user_id', $userId)
            ->orderBy('month')->orderBy('day')->get(['name','day','month','year','notes']);
        $tmp = fopen('php://temp', 'r+');
        fputcsv($tmp, ['Name', 'Day', 'Month', 'Year', 'Notes']);
        foreach ($rows as $row) {
            fputcsv($tmp, [
                $row['name'],
                '="'.str_pad($row['day'],2,'0', STR_PAD_LEFT).'"',
                '="'.str_pad($row['month'],2,'0', STR_PAD_LEFT).'"',
                $row['year'] ?? '',
                $row['notes'] ?? '',
            ]);

        }
        rewind($tmp);
        $csv = stream_get_contents($tmp);

        return "\xEF\xBB\xBF" . $csv; // BOM pentru Excel
    }

    public function toIcs(int $userId): string
    {
        $rows = Birthday::where('user_id', $userId)->get(['name','day','month']);
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Birthday Reminder//EN',
            'CALSCALE:GREGORIAN',
        ];

        $year = now()->year;
        foreach ($rows as $r) {
            // all-day recurring yearly event
            $dt = sprintf('%04d%02d%02d', $year, $r->month, $r->day);
            $uid = md5($r->name.$r->month.$r->day.'-'.$userId).'@birthday';
            $lines[] = 'BEGIN:VEVENT';
            $lines[] = "UID:$uid";
            $lines[] = "SUMMARY:🎂 {$r->name}";
            $lines[] = "DTSTART;VALUE=DATE:$dt";
            $lines[] = "RRULE:FREQ=YEARLY";
            $lines[] = 'END:VEVENT';
        }

        $lines[] = 'END:VCALENDAR';
        return implode("\r\n", $lines)."\r\n";
    }

    private function xlsText(string $v): string
    {
        return '=\"'.str_replace('\"','\"\"',$v).'\"';
    }



}
