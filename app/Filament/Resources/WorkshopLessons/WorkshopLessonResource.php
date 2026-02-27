<?php

namespace App\Filament\Resources\WorkshopLessons;

use App\Filament\Resources\WorkshopLessons\Pages\CreateWorkshopLesson;
use App\Filament\Resources\WorkshopLessons\Pages\EditWorkshopLesson;
use App\Filament\Resources\WorkshopLessons\Pages\ListWorkshopLessons;
use App\Filament\Resources\WorkshopLessons\Pages\ViewWorkshopLesson;
use App\Filament\Resources\WorkshopLessons\Schemas\WorkshopLessonForm;
use App\Filament\Resources\WorkshopLessons\Schemas\WorkshopLessonInfolist;
use App\Filament\Resources\WorkshopLessons\Tables\WorkshopLessonsTable;
use App\Models\WorkshopLesson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WorkshopLessonResource extends Resource
{
    protected static ?string $model = WorkshopLesson::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Atividade';

    protected static ?string $pluralModelLabel = 'Atividades';

    public static function form(Schema $schema): Schema
    {
        return WorkshopLessonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WorkshopLessonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkshopLessonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkshopLessons::route('/'),
            'create' => CreateWorkshopLesson::route('/create'),
            'view' => ViewWorkshopLesson::route('/{record}'),
            'edit' => EditWorkshopLesson::route('/{record}/edit'),
        ];
    }
}
