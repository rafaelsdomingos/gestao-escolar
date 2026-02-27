<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use App\Filament\Widgets\WorkshopWidget;

class WorkshopDashboard extends BaseDashboard
{
    protected static ?string $title = 'Calendário de oficinas';

    protected static string $routePath = 'workshop-dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public function getWidgets(): array
    {
        return [
            WorkshopWidget::class,
        ];
    }
}