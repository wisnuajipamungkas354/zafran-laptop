<?php

namespace App\Filament\Resources\LaptopResource\Pages;

use App\Filament\Resources\LaptopResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class CreateLaptop extends CreateRecord
{
    protected static string $resource = LaptopResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Data Laptop';
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = auth()->user()->id;

        return static::getModel()::create($data);
    }
}
