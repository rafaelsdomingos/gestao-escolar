<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static string $routePath = 'dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    public function getWidgets(): array
    {
        return [

        ];
    }
}