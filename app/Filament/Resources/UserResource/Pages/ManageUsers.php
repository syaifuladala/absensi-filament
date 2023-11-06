<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getActions(): array
    {
        $user = Auth::user();
        if ($user->admin) {
            return [
                Action::make('download')
                    ->url(fn () => url('download/user'))
                    ->openUrlInNewTab(),
                Actions\CreateAction::make(),
            ];
        }

        return [];
    }

    protected function getTableQuery(): Builder
    {
        $user = Auth::user();
        if ($user->admin) {
            return User::query();
        }

        return User::where('id', $user->id);
    }
}
