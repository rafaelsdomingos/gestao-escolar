 <x-layout-report>
    <x-header-report/>

    <h3 class="title">{{ Str::upper($subjectClass->schoolClass->course->academicCoordination->name) }} - FREQUÊNCIA MENSAL</h3>
    <h3 class="title">{{ Str::upper($subjectClass->subject->name) }} - {{Str::upper($subjectClass->schoolClass->name)}}</h3>

    <table class="info-table">
        <tr>
            <td><strong>CURSO:</strong> {{ Str::upper($subjectClass->schoolClass->course->name) }}</td>
        </tr>
        <tr>
            <td><strong>MÊS:</strong> {{ Str::upper( \Carbon\Carbon::createFromDate(null, $month, 1)->isoFormat('MMMM') ) }}</td>
            <td><strong>TURNO:</strong> {{ Str::upper( $subjectClass->schoolClass->shift ) }}</td>
        </tr>
        <tr>
            <td><strong>PROFESSOR(A):</strong> {{ Str::upper($subjectClass->user->name) }}</td>
            <td><strong>COORDENADOR(A):</strong> {{ Str::upper($subjectClass->schoolClass->course->academicCoordination->coordinator) }}</td>
        </tr>
    </table>

@if($lessons->isEmpty())
    <p class="title">
        Não há aulas registradas neste mês.
    </p>
@else
    <table>
        <thead>
            <tr>
                <th>Nº</th>
                <th>ESTUDANTE</th>
                @foreach($lessons as $lesson)
                    <th>
                        {{ Str::upper(\Carbon\Carbon::parse($lesson->date)->translatedFormat('D') )}}<br>
                        {{ \Carbon\Carbon::parse($lesson->date)->format('d/m') }}
                    </th>
                @endforeach
                <th>P</th>
                <th>F</th>
                <th>%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $key => $student)
                @php
                    $stat = $statistics[$student->id];
                    $belowLimit = $stat['percentage'] < 75;
                @endphp
                <tr>
                    <td>{{$key + 1}}</td>
                    <td style="text-align: left;">{{ $student->name }}</td>
                    @foreach($lessons as $lesson)
                        @php
                            $present = $attendanceMap[$student->id][$lesson->id] ?? null;
                        @endphp
                    <td>
                        @if($present === true)
                            P
                        @elseif($present === false)
                            F
                        @else
                            -
                        @endif
                    </td>
                    @endforeach
                    <td>{{ $stat['present'] }}</td>
                    <td>{{ $stat['absent'] }}</td>
                    <td 
                        @if($belowLimit)
                            style="color: red; font-weight: bold;"
                        @endif
                    >
                        {{ $stat['percentage'] }}%
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout-report>