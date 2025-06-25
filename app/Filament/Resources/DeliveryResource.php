<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryResource\Pages;
use App\Filament\Resources\DeliveryResource\RelationManagers;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;

class DeliveryResource extends Resource
{
    protected static ?string $model = Delivery::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Database';

    protected static ?string $navigationLabel = 'Pengiriman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->label('Pilih Order')
                    ->options(fn() => Order::query()->where('order_status', '=', 'shipped')->pluck('id', 'order_number'))
                    ->columnSpanFull(),
                Select::make('courier_id')
                    ->label('Pilih Kurir')
                    ->options(function() {
                        $options = User::with('roles')->get();
                        $result = [];
                        foreach($options as $option) {
                            if($option->roles[0]->name == 'kurir') {
                                $result = [
                                    ...$result,
                                    $option->id => $option->name,
                                ];
                            }
                        }
                        return $result;
                    }),
                DatePicker::make('shipping_date')
                    ->label('Tanggal Pengiriman'),
                Select::make('delivery_status')
                    ->label('Status Pengiriman')
                    ->options([
                        'pending' => 'Menunggu Pickup',
                        'on_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Sudah Diterima',
                        'failed' => 'Gagal'
                    ])
                    ->visible(fn() => auth()->user()->roles[0]->name == 'kurir')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shipping_date')
                ->label('Tanggal Pengiriman')
                ->date('d/m/y'),
                TextColumn::make('order_number')
                    ->label('No Order')
                    ->searchable(),
                TextColumn::make('delivery_status')
                    ->label('Status Pengiriman')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'on_delivery' => 'info',
                        'delivered' => 'success',
                        'failed' => 'failed',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Menunggu Pickup',
                        'on_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Sudah Diterima',
                        'failed' => 'Gagal',
                    }),
            ])
            ->filters([
                SelectFilter::make('delivery_status')
                    ->label('Status Pengiriman')
                    ->options([
                        'pending' => 'Menunggu Pickup',
                        'on_delivery' => 'Sedang Dikirim',
                        'delivered' => 'Sudah Diterima',
                        'failed' => 'Gagal',
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        if($data['delivery_status'] == 'delivered') {
                            $data['delivery_date'] = now();
                        }
        
                        return $data;
                    })
                    ->after(function(array $data) {
                        if($data['delivery_status'] == 'delivered') {
                            $order = Order::findOrFail($data['order_id']);
                            $order->update(['order_status' => 'delivered']);
                        }
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada yang dikirim');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDeliveries::route('/'),
        ];
    }
}
