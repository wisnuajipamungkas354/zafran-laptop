<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';

    protected static ?string $navigationLabel = 'Pelanggan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('email')
                    ->placeholder('Masukkan email')
                    ->required(),
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->placeholder('Masukkan password')
                    ->required(),
                TextInput::make('first_name')
                    ->label('Nama Depan')
                    ->placeholder('Masukkan nama depan')
                    ->required(),
                TextInput::make('last_name')
                    ->label('Nama Belakang')
                    ->placeholder('Masukkan nama depan'),
                TextInput::make('phone_number')
                    ->label('No Telepon')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->placeholder('Masukkan nomor telepon')
                    ->minLength(11)
                    ->maxLength(14)
                    ->required(),
                Textarea::make('address')
                    ->label('Alamat')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Nama Depan'),
                TextColumn::make('last_name')
                    ->label('Nama Belakang'),
                TextColumn::make('email')
                    ->label('Email'),
                TextColumn::make('phone_number')
                    ->label('No HP'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Tidak ada data pelanggan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
