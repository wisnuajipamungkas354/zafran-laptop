<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Laptop;
use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatLaptop extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Stok Laptop', Laptop::query()->count()),
            Stat::make('Order', Order::query()->count()),
            Stat::make('User', User::query()->count()),
            Stat::make('Pelanggan', Customer::query()->count()),
        ];
    }
}
