<?php

namespace App\Filament\Resources\BorrowerResource\Pages;

use Illuminate\Database\Eloquent\Model;

use App\Filament\Resources\BorrowerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBorrower extends EditRecord
    protected function afterSave(): void
    {
        $record = $this->record;
        $collateralItems = $this->data['collateral_items'] ?? [];
        // Remove old collaterals for this borrower
        \App\Models\Collateral::where('borrower_id', $record->id)->delete();
        foreach ($collateralItems as $item) {
            $collateral = new \App\Models\Collateral();
            $collateral->borrower_id = $record->id;
            $collateral->collateral_name = $item['collateral_name'] ?? null;
            $collateral->item_value = $item['item_value'] ?? null;
            $collateral->item_type = $item['item_type'] ?? null;
            $collateral->document_path = $item['collateral_image'][0]['file_name'] ?? null;
            $collateral->save();
        }
    }
{
    protected static string $resource = BorrowerResource::class;
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $data['full_name'] = $data['first_name'] . ' ' . $data['last_name'] . ' - ' . $data['mobile'];
        $record->update($data);

        return $record;
    }
    protected function getHeaderActions(): array
    {


        return [
            Actions\DeleteAction::make(),
        ];
    }
}
