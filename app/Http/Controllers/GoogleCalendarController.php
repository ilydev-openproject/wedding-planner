<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    public function addEvent($checklist_id)
    {
        $checklist = Checklist::findOrFail($checklist_id);

        if ($checklist->due_date && $checklist->task) {
            $start = Carbon::parse($checklist->due_date)->setTime(9, 0);
            $end = $start->copy()->addHour();

            Event::create([
                'name' => $checklist->task,
                'description' => 'Pengingat tugas dari wedding planner: ' . $checklist->task,
                'startDateTime' => $start,
                'endDateTime' => $end,
            ]);

            return redirect()->back()->with('success', 'Berhasil menambahkan ke Google Calendar!');
        }

        return redirect()->back()->with('error', 'Checklist belum memiliki due_date atau task.');
    }
}
