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
                Tables\Columns\TextColumn::make('next_of_kin_first_name')->label('Next of Kin First Name'),
                Tables\Columns\TextColumn::make('next_of_kin_last_name')->label('Next of Kin Last Name'),
                Tables\Columns\TextColumn::make('phone_next_of_kin')->label('Phone Next of Kin'),
                Tables\Columns\TextColumn::make('address_next_of_kin')->label('Address Next of Kin'),
                Tables\Columns\TextColumn::make('relationship_next_of_kin')->label('Relationship to Next of Kin'),
                Tables\Columns\TextColumn::make('bank_name')->label('Bank Name'),
                Tables\Columns\TextColumn::make('bank_branch')->label('Bank Branch'),
                Tables\Columns\TextColumn::make('bank_sort_code')->label('Bank Sort Code'),
                Tables\Columns\TextColumn::make('bank_account_number')->label('Bank Account Number'),
                Tables\Columns\TextColumn::make('bank_account_name')->label('Bank Account Name'),
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
                Forms\Components\TextInput::make('first_name')
                    ->label('First Name')
                    ->prefixIcon('heroicon-o-user')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('Last Name')
                    ->prefixIcon('heroicon-o-user')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('full_name')
                    ->hidden(),
                Forms\Components\Select::make('gender')
                    ->label('Gender')
                    ->prefixIcon('heroicon-o-users')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->prefixIcon('heroicon-o-calendar')
                    ->required()
                    ->native(false)
                    ->maxDate(now()),
                Forms\Components\Select::make('occupation')
                    ->options([
                        'employed' => 'Employed',
                        'self employed' => 'Self Employed',
                        'unemployed' => 'Un-Employed',
                        'student' => 'Student',
                    ])
                    ->prefixIcon('heroicon-o-briefcase')
                    ->required(),
                Forms\Components\TextInput::make('identification')
                    ->label('National ID')
                    ->prefixIcon('heroicon-o-identification')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->label('Phone number')
                    ->prefixIcon('heroicon-o-phone')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email address')
                    ->prefixIcon('heroicon-o-envelope')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('City')
                    ->prefixIcon('fas-map-marker')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('province')
                    ->label('Province')
                    ->prefixIcon('fas-map-marker')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('zipcode')
                    ->label('Zipcode')
                    ->prefixIcon('fas-map-marker')
                    ->maxLength(255),
                Forms\Components\TextInput::make('next_of_kin_first_name')
                    ->label('Next of Kin First Name')
                    ->prefixIcon('fas-user')
                    ->maxLength(255),
                Forms\Components\TextInput::make('next_of_kin_last_name')
                    ->label('Next of Kin Last Name')
                    ->prefixIcon('fas-users')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone_next_of_kin')
                    ->label('Phone Next of Kin')
                    ->prefixIcon('heroicon-o-phone')
                    ->tel(),
                Forms\Components\Textarea::make('address_next_of_kin')
                    ->maxLength(255),
                Forms\Components\Select::make('relationship_next_of_kin')
                    ->label('Relationship to Next of Kin')
                    ->options([
                        'mom' => 'Mom',
                        'father' => 'Father',
                        'aunty' => 'Aunty',
                        'uncle' => 'Uncle',
                        'cousin' => 'Cousin',
                        'wife' => 'Wife',
                        'husband' => 'Husband',
                        'brother' => 'Brother',
                        'Sister' => 'Sister',
                    ]),
                Forms\Components\TextInput::make('bank_name')
                    ->label('Bank Name')
                    ->prefixIcon('fas-building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_branch')
                    ->label('Bank Branch')
                    ->prefixIcon('fas-building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_sort_code')
                    ->label('Bank Sort Code')
                    ->prefixIcon('fas-building')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_account_number')
                    ->label('Bank Account Number')
                    ->prefixIcon('fas-dollar-sign')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_account_name')
                    ->label('Bank Account Name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile_money_name')
                    ->label('Mobile Money Name')
                    ->prefixIcon('fas-phone')
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile_money_number')
                    ->label('Mobile Money Number')
                    ->prefixIcon('fas-user')
                    ->tel(),
                SpatieMediaLibraryFileUpload::make('payslips')
                    ->disk('borrowers')
                    ->collection('payslips')
                    ->visibility('public')
                    ->multiple()
                    ->minFiles(0)
                    ->maxFiles(10)
                    ->maxSize(5120)
                    ->columnSpan(2)
                    ->openable(),
                SpatieMediaLibraryFileUpload::make('bank_statements')
                    ->disk('borrowers')
                    ->collection('bank_statements')
                    ->visibility('public')
                    ->multiple()
                    ->minFiles(0)
                    ->maxFiles(10)
                    ->maxSize(5120)
                    ->columnSpan(2)
                    ->openable(),
                SpatieMediaLibraryFileUpload::make('nrc')
                    ->disk('borrowers')
                    ->collection('nrc')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->columnSpan(2)
                    ->openable(),
                SpatieMediaLibraryFileUpload::make('preapproval_letter')
                    ->disk('borrowers')
                    ->collection('preapproval_letter')
                    ->visibility('public')
                    ->minFiles(0)
                    ->maxSize(5120)
                    ->columnSpan(2)
                    ->openable(),
                SpatieMediaLibraryFileUpload::make('proof_of_residence')
                    ->disk('borrowers')
                    ->collection('proof_of_residence')
                    ->visibility('public')
                    ->minFiles(0)
                    ->maxSize(5120)
                    ->columnSpan(2)
                    ->openable(),
                Forms\Components\Repeater::make('collateral_items')
                    ->label('Collateral Items')
                    ->schema([
                        Forms\Components\TextInput::make('collateral_name')
                            ->label('Collateral Name')
                            ->required(),
                        Forms\Components\TextInput::make('item_value')
                            ->label('Market Value (UGX)')
                            ->numeric(),
                        Forms\Components\TextInput::make('item_type')
                            ->label('Type'),
                        SpatieMediaLibraryFileUpload::make('collateral_image')
                            ->disk('borrowers')
                            ->collection('collaterals')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->openable(),
                    ])
                    ->minItems(0)
                    ->maxItems(10)
                    ->columnSpan(2),
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
            Section::make('Personal Details')
                ->description('Borrower Personal Details')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    // ...existing personal details code...
                ]),
            Section::make('Collateral Details')
                ->description('All collateral items for this borrower')
                ->icon('heroicon-o-archive-box')
                ->schema([
                    ...\App\Models\Collateral::where('borrower_id', $borrower->id)->get()->map(function ($collateral) use ($borrower) {
                        $media = $borrower->getMedia('collaterals')->firstWhere('file_name', $collateral->document_path);
                        return Grid::make(2)
                            ->schema([
                                TextEntry::make('collateral_name')->label('Collateral Name')->default($collateral->collateral_name ?? '-'),
                                TextEntry::make('item_value')->label('Market Value (UGX)')->default($collateral->item_value ?? '-'),
                                TextEntry::make('item_type')->label('Type')->default($collateral->item_type ?? '-'),
                                TextEntry::make('item_description')->label('Description')->default($collateral->item_description ?? '-'),
                                TextEntry::make('loan_id')->label('Loan ID')->default($collateral->loan_id ?? '-'),
                                Actions::make([
                                    Action::make('download_' . ($media ? $media->id : $collateral->id))
                                        ->label('Download Collateral')
                                        ->icon('heroicon-o-arrow-down-tray')
                                        ->url($media ? $media->getUrl() : '#')
                                        ->openUrlInNewTab()
                                        ->outlined()
                                        ->color('primary'),
                                    Action::make('view_' . ($media ? $media->id : $collateral->id))
                                        ->label('View Collateral')
                                        ->icon('heroicon-o-eye')
                                        ->url($media ? $media->getUrl() : '#')
                                        ->openUrlInNewTab()
                                        ->outlined()
                                        ->color('secondary'),
                                ])
                            ]);
                    })->toArray(),
                ]),
            // ...other sections as needed...
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBorrowers::route('/'),
            'create' => Pages\CreateBorrower::route('/create'),
            'view' => Pages\ViewBorrower::route('/{record}'),
            'edit' => Pages\EditBorrower::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers here if needed
        ];
    }
}
