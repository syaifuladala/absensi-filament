<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceWidget extends Widget
{
    protected static string $view = 'filament.widgets.attendance-widget';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;

    public $attendance;

    public function mount()
    {
        $this->attendance = 0;
    }

    public function button1Action()
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $now = Carbon::now();
            $clockIn = Carbon::parse($now->format('Y-m-d') . config('constants.clock_in'));
            $checkAttendance = Attendance::where('user_id', $user->id)->where('date', $now->format('Y-m-d'))->first();
            if (empty($checkAttendance)) {
                $late = false;
                if ($now->gt($clockIn)) {
                    $late = true;
                }
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $now->format('Y-m-d'),
                    'clock_in' => $now->format('Y-m-d H:i:s'),
                    'clock_out' => null,
                    'late' => $late
                ]);

                DB::commit();
                return redirect('/clock-in/success');
            }

            return redirect('/clock-in/failed');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function button2Action()
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $now = Carbon::now();
            $clockOut = Carbon::parse($now->format('Y-m-d') . config('constants.clock_out'));
            $checkAttendance = Attendance::where('user_id', $user->id)->where('date', $now->format('Y-m-d'))->first();
            if (! empty($checkAttendance)) {

                if ($checkAttendance->clock_out != null) {
                    return redirect('/clock-out/failed?clock_in=true');
                }

                $late = $checkAttendance->late;
                if ($now->lt($clockOut)) {
                    $late = true;
                }

                $checkAttendance->clock_out = $now->format('Y-m-d H:i:s');
                $checkAttendance->late = $late;
                $checkAttendance->save();

                DB::commit();
                return redirect('/clock-out/success?clock_in=false');
            }

            return redirect('/clock-out/failed');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
