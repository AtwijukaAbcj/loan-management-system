<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PesapalSetting;
use App\Filament\Resources\PesapalSettingsResource\Pages;

class PesapalSettingsResource extends Resource
{
    protected static ?string $model = PesapalSetting::class;
    protected static ?string $navigationGroup = 'Addons';
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Pesapal Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('consumer_key')
                    ->label('Consumer Key')
                    ->prefixIcon('heroicon-o-key')
                    ->required(),
                Forms\Components\TextInput::make('consumer_secret')
                    ->label('Consumer Secret')
                    ->prefixIcon('heroicon-o-lock-closed')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Is Active')
                    ->helperText('Activate Pesapal integration for payments.')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('consumer_key')->label('Consumer Key')->searchable(),
                Tables\Columns\TextColumn::make('consumer_secret')->label('Consumer Secret')->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
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
            'index' => Pages\ListPesapalSettings::route('/'),
            'edit' => Pages\EditPesapalSettings::route('/{record}/edit'),
            'create' => Pages\CreatePesapalSettings::route('/create'),
        ];
    }
}
