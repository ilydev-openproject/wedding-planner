<?php

namespace App\Filament\Resources\AcaraResource\Pages;

use App\Filament\Resources\AcaraResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAcara extends CreateRecord
{
    protected static string $resource = AcaraResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!auth()->user()->hasRole('admin')) {
            $data['user_id'] = auth()->id(); // paksa inject user_id jika bukan admin
        }

        return $data;
    }
}
