<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checklist extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected static function booted()
    {
        static::created(function ($checklist) {
            if ($checklist->due_date && $checklist->task) {
                $start = Carbon::parse($checklist->due_date . ' 09:00', 'Asia/Jakarta');
                $end = $start->copy()->addHour();


                Event::create([
                    'name' => $checklist->task,
                    'description' => 'Pengingat tugas dari wedding planner: ' . $checklist->task,
                    'startDateTime' => $start,
                    'endDateTime' => $end,
                ]);
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
