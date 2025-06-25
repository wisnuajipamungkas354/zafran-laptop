<?php

namespace App\Filament\Resources\LaptopResource\Pages;

use App\Filament\Resources\LaptopResource;
use Filament\Actions;
use Filament\Notifications\Notification;
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

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Berhasil')
            ->body('Data laptop berhasil ditambahkan');
    }
}
