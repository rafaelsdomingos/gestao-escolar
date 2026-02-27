<?php

namespace App\Filament\Resources\WorkshopLessons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\FontWeight;

class WorkshopLessonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        TextEntry::make('workshop.name')
                            ->label('Atividade:')
                            ->hiddenLabel()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold)
                            ->columnSpanFull(),
                        TextEntry::make('date')
                            ->label('Data da aula:')
                            ->weight(FontWeight::Bold)
                            ->date('d/m/Y'),
                        TextEntry::make('workshop.user.name')
                            ->weight(FontWeight::Bold)
                            ->label('Professor(a):'),
                        TextEntry::make('starts_at')
                            ->label('Início:')
                            ->time(),
                        TextEntry::make('ends_at')
                            ->label('Término:')
                            ->time(),
                    ])->columnSpanFull()->columns(2),
            ]);
    }
}
