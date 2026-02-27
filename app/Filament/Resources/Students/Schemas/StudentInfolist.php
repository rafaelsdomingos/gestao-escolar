<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Enums\RaceColor;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('social_name')
                    ->placeholder('-'),
                TextEntry::make('nationality'),
                TextEntry::make('birthplace')
                    ->placeholder('-'),
                TextEntry::make('birthdate')
                    ->dateTime('d/m/Y')
                    ->placeholder('-'),
                TextEntry::make('gender')
                    ->placeholder('-'),
                TextEntry::make('race_color')
                    ->formatStateUsing(fn (?RaceColor $state) => $state?->label())
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
