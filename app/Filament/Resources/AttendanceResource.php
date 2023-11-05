<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        $colomns = [
            Tables\Columns\TextColumn::make('date')->dateTime('d M Y')->searchable(),
            Tables\Columns\TextColumn::make('clock_in')->dateTime('H:i'),
            Tables\Columns\TextColumn::make('clock_out')->dateTime('H:i'),
            Tables\Columns\IconColumn::make('late')->boolean(),
        ];

        if ($user->admin) {
            array_unshift(
                $colomns,
                Tables\Columns\TextColumn::make('user.name')->searchable(),
            );
        }

        return $table
            ->columns($colomns)
            ->filters([
                SelectFilter::make('late')
                    ->options([
                        true => 'Yes',
                        false => 'No'
                    ])
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAttendances::route('/'),
        ];
    }
}
