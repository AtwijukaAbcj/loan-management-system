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



class BorrowerResource extends Resource
{
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

}
