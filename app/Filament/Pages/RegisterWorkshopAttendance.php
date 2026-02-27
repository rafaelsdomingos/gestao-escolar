<?php

namespace App\Filament\Pages;

use App\Models\WorkshopLesson;
use App\Models\WorkshopAttendance;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use App\Enums\EnrollStatus;

class RegisterWorkshopAttendance extends Page
{
    protected string $view = 'filament.pages.register-workshop-attendance';

    protected static ?string $slug = 'register-workshop-attendance/{workshop_lesson_id}';

    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];
    public ?WorkshopLesson $lesson = null;
    public array $attendances = [];

    public function mount($workshop_lesson_id): void
    {
        $workshop_lesson_id = (int) $workshop_lesson_id;

        $this->lesson = WorkshopLesson::with([
            'workshop.enrollments.student'
        ])->find($workshop_lesson_id);

        if (!$this->lesson) {
            abort(404);
        }

        $this->loadStudents();
    }

    protected function loadStudents(): void
    {
        $enrollments = $this->lesson
            ->workshop
            ->enrollments
            ->where('status', EnrollStatus::cursando)
            ->sortBy(fn ($e) => $e->student->name);

        $this->attendances = $enrollments->map(function ($enrollment) {

            $attendance = WorkshopAttendance::firstOrNew([
                'workshop_lesson_id' => $this->lesson->id,
                'student_id' => $enrollment->student->id,
            ]);

            return [
                'id' => $enrollment->student->id,
                'name' => $enrollment->student->name,
                'is_present' => $attendance->exists
                    ? $attendance->is_present
                    : true,
            ];
        })->values()->toArray();

        $this->data['is_present'] = collect($this->attendances)
            ->pluck('is_present', 'id')
            ->toArray();
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Grid::make(1)
                    ->schema($this->buildCheckboxes()),
            ])
            ->statePath('data');
    }

    protected function buildCheckboxes(): array
    {
        $fields = [];

        foreach ($this->attendances as $student) {
            $fields[] = Checkbox::make("is_present.{$student['id']}")
                ->label($student['name'])
                ->default($student['is_present']);
        }

        return $fields;
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salvar Frequência')
                ->icon('heroicon-o-document-plus')
                ->action('saveAttendance'),

            Action::make('back')
                ->label('Voltar')
                ->icon('heroicon-o-arrow-left')
                ->color('warning')
                //->url(url()->previous()),
                ->extraAttributes(['onclick' => 'history.back()']),
        ];
    }

    public function saveAttendance(): void
    {
        foreach ($this->attendances as $student) {

            $isPresent = $this->data['is_present'][$student['id']] ?? false;

            WorkshopAttendance::updateOrCreate(
                [
                    'workshop_lesson_id' => $this->lesson->id,
                    'student_id' => $student['id'],
                ],
                [
                    'is_present' => $isPresent,
                ]
            );
        }

        Notification::make()
            ->title('Frequência registrada com sucesso!')
            ->success()
            ->send();
    }

    public function getTitle(): string
    {
        return "Registro de Frequência";
    }
}
