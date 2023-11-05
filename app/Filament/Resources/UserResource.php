<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required()
                    ->disabledOn(['edit']),
                Forms\Components\TextInput::make('password')->password()->required()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('position'),
                Forms\Components\Select::make('admin')->required()
                    ->options([
                        true => 'Ya',
                        false => 'Tidak',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        $filters = [];
        $actions = [
            Tables\Actions\EditAction::make()
        ];
        $colomns = [
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('phone')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('position')->searchable()->sortable(),
        ];

        if ($user->admin) {
            array_push($colomns, Tables\Columns\IconColumn::make('admin')->boolean());
            $filters = [
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('admin')
                    ->options([
                        true => 'Yes',
                        false => 'No'
                    ]),
            ];
            $actions = [
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ]),
            ];
        }

        return $table
            ->columns($colomns)
            ->filters($filters)
            ->actions($actions)
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
