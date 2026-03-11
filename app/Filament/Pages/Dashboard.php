<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Filament\Widgets\StudentOverview;
use Filament\Pages\Dashboard\Actions\FilterAction;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use App\Models\AcademicYear;


class Dashboard extends BaseDashboard
{
    use HasPageShield, HasFiltersAction;
    
    protected static ?string $title = 'Dashboard';

    protected static string $routePath = 'dashboard';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    public function getWidgets(): array
    {
        return [
            StudentOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            FilterAction::make()
                ->schema([
                    Select::make('academic_year_id')
                        ->label('Ano letivo')
                        ->options(
                            AcademicYear::orderBy('year', 'desc')
                                ->pluck('year', 'id')
                        )
                        ->default(
                            AcademicYear::where('is_current', true)->value('id')
                        )
                        ->preload()
                ]),
        ];
    } 

    public function persistsFiltersInSession(): bool
    {
        return true;
    }
}