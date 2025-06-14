<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaptopResource\Pages;
use App\Filament\Resources\LaptopResource\RelationManagers;
use App\Models\Brand;
use App\Models\Laptop;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class LaptopResource extends Resource
{
    protected static ?string $model = Laptop::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

    protected static ?string $navigationLabel = 'Laptop';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('laptop_images')
                    ->label('Upload Foto Laptop')
                    ->disk('public')
                    ->directory('foto-laptop')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->imageEditorMode(1)
                    ->minFiles(2)
                    ->maxFiles(5)
                    ->maxSize(2048)
                    ->required()
                    ->columnSpanFull(),
                Select::make('brand_id')
                    ->placeholder('Pilih brand')
                    ->options(Brand::query()->pluck('brand_name', 'id'))
                    ->required(),
                TextInput::make('model')
                    ->placeholder('Masukkan model laptop')
                    ->required(),
                TextInput::make('processor')
                    ->placeholder('Masukkan processor laptop')
                    ->required(),
                TextInput::make('ram')
                    ->label('RAM')
                    ->placeholder('Masukkan jumlah RAM')
                    ->required(),
                TextInput::make('storage')
                    ->placeholder('Masukkan jumlah penyimpanan')
                    ->required(),
                TextInput::make('graphics_card')
                    ->placeholder('Masukkan jenis kartu grafis'),
                TextInput::make('screen_size')
                    ->label('Ukuran Layar')
                    ->placeholder('Masukkan ukuran layar')
                    ->required(),
                TextInput::make('condition')
                    ->label('Kondisi')
                    ->placeholder('Masukkan kondisi laptop')
                    ->required(),
                TextInput::make('price')
                    ->label('Harga')
                    ->prefix('Rp')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->placeholder('Masukkan harga laptop')
                    ->required(),
                TextInput::make('stock')
                    ->label('Stok')
                    ->numeric()
                    ->suffix('Unit')
                    ->minValue(0)
                    ->placeholder('Masukkan jumlah stok laptop')
                    ->required(),
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Masukkan deskripsi laptop')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('laptop_images')
                    ->label('Foto Laptop')
                    ->disk('public')
                    ->square()
                    ->width(200)
                    ->height(250)
                    ->limit(1)
                    ->visibility('public'),
                TextColumn::make('brand.brand_name')
                    ->label('Merk'),
                TextColumn::make('model'),
                TextColumn::make('condition')
                    ->label('Kondisi'),
                TextColumn::make('stock')
                    ->label('Stok'),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR',locale: 'id'),
                TextColumn::make('user.name')
                    ->label('Ditambahkan oleh'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->modalHeading('Hapus Data')
                    ->modalDescription('Apakah kamu yakin data laptop ini akan dihapus ?')
                    ->modalSubmitActionLabel('Ya')
                    ->modalCancelActionLabel('Batal')
                    ->after(function(Laptop $record) {
                        Storage::disk('public')->delete($record['laptop_images']);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus yang dipilih')
                        ->modalHeading('Hapus beberapa data laptop')
                        ->modalDescription('Apakah kamu yakin beberapa data laptop ini akan dihapus?')
                        ->modalSubmitActionLabel('Ya')
                        ->modalCancelActionLabel('Batal'),
                ]),
            ])
            ->emptyStateHeading('Tidak ada data laptop');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaptops::route('/'),
            'create' => Pages\CreateLaptop::route('/create'),
            'edit' => Pages\EditLaptop::route('/{record}/edit'),
        ];
    }
}
