<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Enums\RaceColor;
use App\Enums\Ser;
use App\Enums\Gender;
use App\Enums\FederalUnit;
use App\Enums\EducationLevel;
use App\Enums\Kinship;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('FORMULÁRIO DE INSCRIÇÃO')
                            ->schema([
                                Fieldset::make('DADOS PESSOAIS')
                                    ->schema([
                                        TextInput::make('name')
                                            ->columnSpan(2)
                                            ->required(),
                                        
                                        DatePicker::make('birthdate')
                                            ->required()
                                            ->label('Data de Nascimento'),
                                        
                                        FileUpload::make('photo')
                                            ->alignment('center')
                                            ->hiddenLabel()
                                            ->avatar(),

                                        TextInput::make('social_name')
                                            ->columnSpan(2)
                                            ->label('Nome Social'),
                                        
                                        TextInput::make('nationality')
                                            ->label('Nacionalidade')
                                            ->required(),                 
                                        
                                        TextInput::make('birthplace')
                                            ->label('Naturalidade'),
                                                                                
                                        Select::make('gender')
                                            ->label('Gênero')
                                            ->options(
                                                collect(Gender::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                                                    ->toArray()
                                            )
                                            ->required()
                                            ->native(false),
                                        
                                        Select::make('race_color')
                                            ->label('Raça/Cor')
                                            ->options(
                                                collect(RaceColor::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                                                    ->toArray()
                                            )
                                            ->required()
                                            ->native(false),
                                        
                                        TextInput::make('address')
                                            ->columnSpan(2)
                                            ->label('Endereço'),
                                        
                                        TextInput::make('neighborhood')
                                            ->label('Bairro'),
                                        
                                        TextInput::make('city')
                                            ->label('Cidade'),
                                        
                                        Select::make('uf')
                                            ->label('Estado')
                                            ->searchable()
                                            ->options(
                                                collect(FederalUnit::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->value])
                                                    ->toArray()
                                            )
                                            ->required()
                                            ->native(false),
                                        
                                        TextInput::make('zip_code')
                                            ->mask('99999-999')
                                            ->label('CEP'),
                                        
                                        Select::make('ser')
                                            ->label('Regional')
                                            ->options(
                                                collect(Ser::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                                                    ->toArray()
                                            )
                                            ->required()
                                            ->native(false),
                                        
                                        TextInput::make('cel_number')
                                            ->mask('(99) 99999-9999')
                                            ->label('Celular/Whatstapp'),
                                        
                                        TextInput::make('email')
                                            ->email()
                                            ->columnSpan(2)
                                            ->label('E-mail'),

                                        Repeater::make('healthConditions')
                                            ->relationship()
                                            ->label('Possui alguma alergia ou deficiência?')
                                            ->schema([  
                                                Select::make('type')
                                                    ->label('Tipo')
                                                    ->options([
                                                        'alergia' => 'Alergia',
                                                        'deficiencia' => 'Deficiência',
                                                    ]),
                                                TextInput::make('description')
                                                    ->label('Descrição')
                                                    ->columnSpan(2),
                                            ])
                                            ->addActionLabel('Registrar alergia/deficiência')
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->columnSpan(4),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),
                                
                                Fieldset::make('DADOS ACADÊMICOS')
                                    ->schema([
                                        Select::make('education_level')
                                            ->label('Escolaridade')
                                            ->options(
                                                collect(EducationLevel::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                                                    ->toArray()
                                            )
                                            ->required()
                                            ->native(false),
                                        
                                        TextInput::make('grade')
                                            ->label('Série'),

                                        Select::make('shift')
                                            ->label('Turno')
                                            ->options([
                                                'manha' => 'Manhã',
                                                'tarde' => 'Tarde',
                                                'noite' => 'Noite',
                                                'tempo_integral' => 'Tempo Integral',
                                            ]),

                                        TextInput::make('institution')
                                            ->columnSpan(2)
                                            ->label('Instituição de Ensino'),

                                        Select::make('institution_type')
                                            ->label('Tipo')
                                            ->options([
                                                'publica' => 'Pública',
                                                'privada' => 'Privada',
                                            ]),
                                    ])
                                    ->columns(3)
                                    ->columnSpanFull(),

                                Fieldset::make('DOCUMENTAÇÃO')
                                    ->schema([                      
                                        TextInput::make('cpf')
                                            ->label('CPF')
                                            ->unique(ignoreRecord: true)
                                            ->validationMessages([
                                                'unique' => 'Já existe um estudante com este CPF cadastrado.',
                                            ]),

                                        TextInput::make('rg')
                                            ->label('RG')
                                            ->unique(ignoreRecord: true)
                                            ->validationMessages([
                                                'unique' => 'Já existe um estudando com esse RG cadastrado',
                                            ]),
                                        
                                        TextInput::make('rg_authority')
                                            ->label('Emissor'),

                                        Select::make('rg_state')
                                            ->label('UF')
                                            ->options(
                                                collect(FederalUnit::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->value])
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->native(false),
                                        
                                        TextInput::make('mother_name')
                                            ->label('Nome da mãe'),

                                        TextInput::make('mother_rg')
                                            ->label('RG da mãe'),
                                        
                                        TextInput::make('mother_rg_authority')
                                            ->label('Emissor'),

                                        Select::make('mother_rg_state')
                                            ->label('UF')
                                            ->options(
                                                collect(FederalUnit::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->value])
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->native(false),
                                        
                                        TextInput::make('father_name')
                                            ->label('Nome do pai'),

                                        TextInput::make('father_rg')
                                            ->label('RG do pai'),
                                        
                                        TextInput::make('father_rg_authority')
                                            ->label('Emissor'),

                                        Select::make('father_rg_state')
                                            ->label('UF')
                                            ->options(
                                                collect(FederalUnit::cases())
                                                    ->mapWithKeys(fn ($case) => [$case->value => $case->value])
                                                    ->toArray()
                                            )
                                            ->searchable()
                                            ->native(false),
                                        
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),

                                Fieldset::make('CONTATOS ADICIONAIS')
                                    ->schema([                      
                                        Repeater::make('contacts')
                                            ->relationship()
                                            ->label('Contatos adicionais')
                                            ->hiddenLabel()
                                            ->schema([  
                                                Select::make('relationship')
                                                    ->label('Parentesco')
                                                    ->options(
                                                        collect(Kinship::cases())
                                                            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
                                                            ->toArray()
                                                    ),
                                                TextInput::make('name')
                                                    ->label('Nome'),
                                                TextInput::make('phone')
                                                    ->mask('(99) 99999-9999')
                                                    ->label('Contato'),
                                            ])
                                            ->addActionLabel('Adicionar contatos')
                                            ->defaultItems(0)
                                            ->columnSpan(4)
                                            ->columns(3)
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull(),
                            ]),
                        Tab::make('DOCUMENTAÇÃO')
                            ->schema([
                                Repeater::make('documents')
                                    ->relationship()
                                    ->label('Documentos entregues')
                                    ->hiddenLabel()
                                    ->schema([  
                                        TextInput::make('year')
                                            ->label('Ano letivo'),
                                        CheckboxList::make('docs')
                                            ->options([
                                                'rg' => 'RG',
                                                'cpf' => 'CPF',
                                                'address_comp' => 'Comprovante de endereço',
                                                '1' => 'Declaração de matrícula',
                                                '3' => 'Atestado médico',
                                                '3' => 'Laudo',
                                                '4' => 'Comprovante de renda',
                                                '5' => 'Certidão de nascimento',
                                                '6' => 'RG do responsável',
                                                '7' => 'Transporte',
                                                '8' => 'Declaração de foto',
                                            ])->columns(4)->columnSpan(4)

                                    ])
                                    ->addActionLabel('Adicionar documentação')
                                    ->defaultItems(0)
                                    ->columnSpanFull()
                                    ->columns(4),
                            ]),
                        ])->columnSpanFull(),
            ])->columns(4);
    }
}
