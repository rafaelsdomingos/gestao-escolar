<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use App\Filament\Widgets\CalendarWidget;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SchoolClassDashboard extends BaseDashboard
{
    use HasPageShield;
    
    protected static ?string $title = 'Calendário de turmas';

    protected static string $routePath = 'schoolclass-dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDateRange;

    public function getWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }
}