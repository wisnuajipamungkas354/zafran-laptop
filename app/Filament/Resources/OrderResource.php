<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Database';

    protected static ?string $navigationLabel = 'Order';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_status')
                    ->label('Status Order')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Diproses Admin',
                        'shipped' => 'Sedang Dikirim',
                        'delivered' => 'Sudah Diterima',
                        'canceled' => 'Dibatalkan'
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d/m/Y H:i'),
                TextColumn::make('order_number')
                    ->label('No Order')
                    ->searchable(),
                TextColumn::make('customer.first_name')
                    ->label('Nama Pelanggan')
                    ->formatStateUsing(fn(string $state, Order $order) => $state . ' ' . $order->customer->last_name)
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->label('Total Transaksi')
                    ->formatStateUsing(fn(string $state) => 'Rp' . number_format($state, 0, ',', '.'))
                    ->alignEnd(),
                TextColumn::make('payment_status')
                    ->label('Status Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'canceled' => 'danger',
                    })
                    ->formatStateUsing(function(string $state) {
                        if($state == 'pending') {
                            return 'Belum Dibayar';
                        } elseif($state == 'paid') {
                            return 'Dibayar';
                        } else {
                            return 'Dibatalkan';
                        }
                    }),
                TextColumn::make('order_status')
                    ->label('Status Order')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'info',
                        'shipped' => 'info',
                        'delivered' => 'success',
                        'canceled' => 'danger'
                    })
                    ->formatStateUsing(function(string $state) {
                        if($state == 'pending') {
                            return 'Menunggu Pembayaran';
                        } elseif($state == 'processing') {
                            return 'Diproses Admin';
                        } elseif($state == 'shipped') {
                            return 'Sedang Dikirim';
                        } elseif($state == 'delivered') {
                            return 'Sudah Diterima';
                        } else {
                            return 'Dibatalkan';
                        }
                    })
                
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'pending' => 'Belum Dibayar',
                        'paid' => 'Dibayar',
                        'canceled' => 'Dibatalkan',
                    ]),
                SelectFilter::make('order_status')
                    ->options([
                        'pending' => 'Menunggu Pembayaran',
                        'processing' => 'Diproses Admin',
                        'shipped' => 'Sedang Dikirim',
                        'delivered' => 'Sudah Diterima',
                        'canceled' => 'Dibatalkan'
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('Pdf')
                ->form([
                    Forms\Components\Select::make('payment_status')
                        ->label('Status Pembayaran')
                        ->options([
                            '' => 'Semua',
                            'pending' => 'Belum Dibayar',
                            'paid' => 'Dibayar',
                            'canceled' => 'Dibatalkan',
                        ]),
                    Forms\Components\Select::make('order_status')
                        ->label('Status Order')
                        ->options([
                            '' => 'Semua',
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses Admin',
                            'shipped' => 'Sedang Dikirim',
                            'delivered' => 'Sudah Diterima',
                            'canceled' => 'Dibatalkan'
                        ]),
                    Forms\Components\DatePicker::make('start')
                        ->label('Dari Tanggal'),
                    Forms\Components\DatePicker::make('end')
                        ->label('Sampai Tanggal'),
                ])
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action(function (array $data) {
                    // Simpan data filter ke session flash & redirect
                    session()->flash('filter_export', $data);
                    redirect()->route('admin.orders.export.pdf');
                })
                ->modalSubmitActionLabel('Unduh'),
                Action::make('Export Excel')
                ->form([
                    Forms\Components\Select::make('payment_status')
                        ->label('Status Pembayaran')
                        ->options([
                            '' => 'Semua',
                            'pending' => 'Belum Dibayar',
                            'paid' => 'Dibayar',
                            'canceled' => 'Dibatalkan',
                        ]),
                    Forms\Components\Select::make('order_status')
                        ->label('Status Order')
                        ->options([
                            '' => 'Semua',
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses Admin',
                            'shipped' => 'Sedang Dikirim',
                            'delivered' => 'Sudah Diterima',
                            'canceled' => 'Dibatalkan'
                        ]),
                    Forms\Components\DatePicker::make('start')->label('Dari Tanggal'),
                    Forms\Components\DatePicker::make('end')->label('Sampai Tanggal'),
                ])
                ->label('Excel')
                ->icon('heroicon-o-document-arrow-down')
                ->color('success')
                ->action(function (array $data) {
                    session()->flash('filter_export', $data);
                    redirect()->route('admin.orders.export.excel');
                })
                ->modalSubmitActionLabel('Unduh'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Tidak ada orderan');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrders::route('/'),
        ];
    }
}
