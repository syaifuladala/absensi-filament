<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now();

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday() && !in_array($startDate->dayOfWeek, [6, 7])) { // Hari Senin-Jumat
                foreach ($users as $user) {
                    $clockIn = $startDate->copy()->setHour(8)->setMinute(rand(0, 40));
                    $clockOut = $startDate->copy()->setHour(17)->setMinute(rand(0, 10));

                    $late = (int)Carbon::parse($clockIn)->format('i') > 30;

                    Attendance::create([
                        'user_id' => $user->id,
                        'date' => $startDate,
                        'clock_in' => $clockIn,
                        'clock_out' => $clockOut,
                        'late' => $late,
                    ]);
                }
            }

            $startDate->addDay();
        }
    }
}
