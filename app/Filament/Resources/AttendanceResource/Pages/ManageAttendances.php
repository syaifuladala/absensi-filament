<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Models\Attendance;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageAttendances extends ManageRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('download')
                    ->url(fn () => url('download/attendance'))
                    ->openUrlInNewTab(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();
        if ($user->admin) {
            return Attendance::orderBy('date', 'DESC');
        }

        return Attendance::where('user_id', $user->id)->orderBy('date', 'DESC');
    }
}
