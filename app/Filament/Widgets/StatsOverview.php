<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $userId = Auth::user()->id;
        $date = Carbon::now()->format('m');
        return [
            Card::make('Total Kehadiran Bulan Ini', Attendance::where('user_id', $userId)->whereMonth('date', $date)->count()),
            Card::make('Total Terlambat Bulan Ini', Attendance::where('user_id', $userId)->whereMonth('date', $date)->where('late', true)->count()),
        ];
    }
}
