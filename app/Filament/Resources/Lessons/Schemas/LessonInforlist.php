<?php

namespace App\Filament\Resources\Lessons\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\FontWeight;

class LessonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('')
                    ->schema([
                        TextEntry::make('subjectClass.subject.name')
                            ->label('Módulo:')
                            ->hiddenLabel()
                            ->columnSpanFull()
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('subjectClass.schoolClass.course.name')
                            ->hiddenLabel()
                            ->weight(FontWeight::Bold)
                            ->label('Curso:'),
                        TextEntry::make('subjectClass.schoolClass.name')
                            ->hiddenLabel()
                            ->weight(FontWeight::Bold)
                            ->label('Turma:'),
                        TextEntry::make('subjectClass.user.name')
                            ->weight(FontWeight::Bold)
                            ->label('Professor(a):'),
                        TextEntry::make('date')
                            ->label('Data da aula:')
                            ->date('d/m/Y'),
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
