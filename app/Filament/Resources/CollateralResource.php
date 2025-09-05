<?php
namespace App\Filament\Resources;
use App\Models\Collateral;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\CollateralResource\Pages;
class CollateralResource extends Resource
{
    protected static ?string $model = Collateral::class;
    protected static ?string $navigationGroup = 'Loans';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Collateral Security';
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('loan_id')
                ->relationship('loan', 'id')
                ->label('Loan')
                ->required(),
            Forms\Components\TextInput::make('item_description')
                ->label('Description')
                ->required(),
            Forms\Components\TextInput::make('item_type')
                ->label('Type'),
            Forms\Components\TextInput::make('item_value')
                ->label('Estimated Value (UGX)')
                ->numeric(),
            Forms\Components\FileUpload::make('document_path')
                ->label('Document')
                ->directory('collateral_docs')
                ->preserveFilenames(),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('loan_id')->label('Loan'),
            Tables\Columns\TextColumn::make('item_description')->label('Description'),
            Tables\Columns\TextColumn::make('item_type')->label('Type'),
            Tables\Columns\TextColumn::make('item_value')->label('Value'),
            Tables\Columns\TextColumn::make('document_path')->label('Document'),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollaterals::route('/'),
            'edit' => Pages\EditCollateral::route('/{record}/edit'),
            'create' => Pages\CreateCollateral::route('/create'),
        ];
    }
}
