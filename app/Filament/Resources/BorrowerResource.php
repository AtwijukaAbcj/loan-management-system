<?php
namespace App\Filament\Resources;

use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\BorrowerResource\Pages;
use App\Filament\Resources\BorrowerResource\RelationManagers;
use App\Models\Borrower;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Exports\BorrowerExporter;
use Filament\Tables\Actions\ExportAction;
use Filament\Support\Enums\ActionSize;
use Filament\Support\Enums\FontWeight;



class BorrowerResource extends Resource {
    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(BorrowerExporter::class)
            ])
            ->columns([
                Tables\Columns\TextColumn::make('first_name')->label('First Name')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label('Last Name')->searchable(),
                Tables\Columns\TextColumn::make('full_name')->label('Full Name')->searchable(),
                Tables\Columns\TextColumn::make('gender')->label('Gender'),
                Tables\Columns\TextColumn::make('dob')->label('Date of Birth')->date(),
                Tables\Columns\TextColumn::make('occupation')->label('Occupation'),
                Tables\Columns\TextColumn::make('identification')->label('National ID'),
                Tables\Columns\TextColumn::make('mobile')->label('Phone')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('address')->label('Address'),
                Tables\Columns\TextColumn::make('city')->label('City'),
                Tables\Columns\TextColumn::make('province')->label('Province'),
                Tables\Columns\TextColumn::make('zipcode')->label('Zipcode'),
                Tables\Columns\TextColumn::make('mobile_money_name')->label('Mobile Money Name'),
                Tables\Columns\TextColumn::make('mobile_money_number')->label('Mobile Money Number'),
                Tables\Columns\TextColumn::make('created_at')->label('Created')->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ...existing code...
                // ...existing code...
            ]);
    }
    protected static ?string $model = Borrower::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Borrowers';
    protected static ?string $navigationGroup = 'Customers';

    public static function infolist(Infolist $infolist): Infolist
    {
        $borrower = $infolist->getRecord();
        return $infolist->schema([
            Grid::make(2)
                ->schema([
                    Section::make('Personal Details')
                        ->schema([
                            TextEntry::make('first_name')->label('First Name')->icon('heroicon-o-user'),
                            TextEntry::make('last_name')->label('Last Name')->icon('heroicon-o-user'),
                            TextEntry::make('full_name')->label('Full Name')->icon('heroicon-o-user-circle'),
                            TextEntry::make('gender')->label('Gender')->icon('heroicon-o-users'),
                            TextEntry::make('dob')->label('Date of Birth')->icon('heroicon-o-calendar'),
                            TextEntry::make('occupation')->label('Occupation')->icon('heroicon-o-briefcase'),
                            TextEntry::make('identification')->label('National ID')->icon('heroicon-o-identification'),
                            TextEntry::make('mobile')->label('Phone')->icon('heroicon-o-phone'),
                            TextEntry::make('email')->label('Email')->icon('heroicon-o-envelope'),
                            TextEntry::make('address')->label('Address')->icon('heroicon-o-home'),
                            TextEntry::make('city')->label('City')->icon('heroicon-o-map'),
                            TextEntry::make('province')->label('Province')->icon('heroicon-o-map'),
                            TextEntry::make('zipcode')->label('Zipcode')->icon('heroicon-o-map'),
                        ]),
                    Section::make('Next of Kin & Bank Details')
                        ->schema([
                            TextEntry::make('next_of_kin_first_name')->label('Next of Kin First Name')->icon('heroicon-o-user'),
                            TextEntry::make('next_of_kin_last_name')->label('Next of Kin Last Name')->icon('heroicon-o-users'),
                            TextEntry::make('phone_next_of_kin')->label('Phone Next of Kin')->icon('heroicon-o-phone'),
                            TextEntry::make('address_next_of_kin')->label('Address Next of Kin')->icon('heroicon-o-home'),
                            TextEntry::make('relationship_next_of_kin')->label('Relationship to Next of Kin')->icon('heroicon-o-users'),
                            TextEntry::make('bank_name')->label('Bank Name')->icon('heroicon-o-banknotes'),
                            TextEntry::make('bank_branch')->label('Bank Branch')->icon('heroicon-o-banknotes'),
                            TextEntry::make('bank_sort_code')->label('Bank Sort Code')->icon('heroicon-o-banknotes'),
                            TextEntry::make('bank_account_number')->label('Bank Account Number')->icon('heroicon-o-banknotes'),
                            TextEntry::make('bank_account_name')->label('Bank Account Name')->icon('heroicon-o-user'),
                            TextEntry::make('mobile_money_name')->label('Mobile Money Name')->icon('heroicon-o-currency-dollar'),
                            TextEntry::make('mobile_money_number')->label('Mobile Money Number')->icon('heroicon-o-phone'),
                        ]),
                ]),
            Section::make('Collateral Details')
                ->schema(
                    \App\Models\Collateral::where('borrower_id', $borrower->id)->get()->map(function ($collateral) use ($borrower) {
                        return [
                            TextEntry::make('collateral_name')->label('Collateral Name')->default($collateral->collateral_name ?? '-')->icon('heroicon-o-archive-box'),
                            TextEntry::make('item_value')->label('Market Value (UGX)')->default($collateral->item_value ?? '-')->icon('heroicon-o-currency-dollar'),
                            TextEntry::make('item_type')->label('Type')->default($collateral->item_type ?? '-')->icon('heroicon-o-tag'),
                            TextEntry::make('item_description')->label('Description')->default($collateral->item_description ?? '-')->icon('heroicon-o-document-text'),
                            TextEntry::make('loan_id')->label('Loan ID')->default($collateral->loan_id ?? '-')->icon('heroicon-o-identification'),
                        ];
                    })->flatten(1)->toArray()
                ),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBorrowers::route('/'),
            'create' => Pages\CreateBorrower::route('/create'),
            'edit'   => Pages\EditBorrower::route('/{record}/edit'),
            'view'   => Pages\ViewBorrower::route('/{record}'),
        ];
    }

}
