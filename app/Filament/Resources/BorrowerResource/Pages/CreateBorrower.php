<?php

namespace App\Filament\Resources\BorrowerResource\Pages;

use App\Filament\Resources\BorrowerResource;
use Filament\Notifications\Notification;
use Auth;
use Filament\Resources\Pages\CreateRecord;


class CreateBorrower extends CreateRecord
{

    protected function afterCreate(): void
    {
        $record = $this->record;
        $collateralItems = $this->data['collateral_items'] ?? [];
        foreach ($collateralItems as $item) {
            if (empty($item['loan_id'])) {
                // Skip or handle error if loan_id is missing
                continue;
            }
            $collateral = new \App\Models\Collateral();
            $collateral->borrower_id = $record->id;
            $collateral->loan_id = $item['loan_id'];
            $collateral->collateral_name = $item['collateral_name'] ?? null;
            $collateral->item_value = $item['item_value'] ?? null;
            $collateral->item_type = $item['item_type'] ?? null;
            $collateral->document_path = $item['collateral_image'][0]['file_name'] ?? null;
            $collateral->save();
        }
    }
    protected static string $resource = BorrowerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        
    $data['full_name'] = $data['first_name']. ' '.$data['last_name']. ' - '.$data['mobile'];
    $data['added_by'] =Auth::user()->id;
    unset($data['collateral_items']);
    return $data;
    }


      protected function getRedirectUrl(): string
    {
       
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Customer created')
            ->body('The Customer has been created successfully.');
    }


                                    
}
