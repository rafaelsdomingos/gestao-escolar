@php use Illuminate\Support\Str; @endphp
<x-filament-panels::page>
    <p>
        <strong>{{ Str::upper($lesson->subjectClass->subject->name) }}</strong><br>
        <strong>{{ $lesson->subjectClass->schoolClass->name }} - {{ $lesson->subjectClass->schoolClass->shift }}</strong><br><br>
        <strong>{{ \Carbon\Carbon::parse($lesson->date)->format('d/m/Y') }}</strong><br>
    </p>
    
    <form wire:submit="saveAttendance" class="space-y-6">

    {{ $this->form }}


    <div class="mt-6 pt-6 border-t flex justify-start gap-3">
        @foreach ($this->getFormActions() as $action)
            {{ $action }}
        @endforeach
    </div>

    </form>
</x-filament-panels::page>
