<?php

namespace App\Filament\Resources;

use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\RoleResource\Pages;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Roles';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\Select::make('permissions')
                ->label('Permissions')
                ->multiple()
                ->preload()
                ->relationship('permissions', 'name')
                ->searchable(),
            Forms\Components\TextInput::make('organization_id')
                ->label('Organization ID')
                ->numeric()
                ->required(),
            Forms\Components\TextInput::make('branch_id')
                ->label('Branch ID')
                ->numeric()
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                    Tables\Columns\TextColumn::make('name')->label('Name')->searchable(),
                    Tables\Columns\TextColumn::make('guard_name')->label('Guard Name')->badge()->searchable(),
                    Tables\Columns\TextColumn::make('permissions_count')
                        ->label('Permissions')
                        ->badge()
                        ->getStateUsing(fn($record) => $record->permissions()->count()),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->label('Updated At')
                        ->dateTime(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }
}
