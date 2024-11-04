<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\OrderStats::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'New' => Tab::make()->query(fn() => Order::query()->whereStatus('new')),
            'Processing' => Tab::make()->query(fn() => Order::query()->whereStatus('processing')),
            'Shipped' => Tab::make()->query(fn() => Order::query()->whereStatus('shipped')),
            'Delivered' => Tab::make()->query(fn() => Order::query()->whereStatus('delivered')),
            'Cancelled' => Tab::make()->query(fn() => Order::query()->whereStatus('cancelled')),
        ];
    }
}
