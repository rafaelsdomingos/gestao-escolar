 <x-layout-report>
    <x-header-report/>
    <h3 class="title">{{ Str::upper($workshop->academicCoordination->name) }} - FREQUÊNCIA MENSAL</h3>
    <h3 class="title">{{ Str::upper($workshop->name) }}</h3>

    <table class="info-table">
        <tr>
            <td><strong>PERÍODO:</strong> {{ \Carbon\Carbon::parse($workshop->start_date)->format('d/m') }} a {{\Carbon\Carbon::parse($workshop->end_date)->format('d/m/Y') }}</td>
            <td>
                @if($lessons->isEmpty())
                    <strong>HORÁRIO:</strong>
                @else
                    <strong>HORÁRIO:</strong> {{ \Carbon\Carbon::parse($lessons[1]->starts_at)->format('H:i') }} às {{ \Carbon\Carbon::parse($lessons[1]->ends_at)->format('H:i')}}
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>PROFESSOR(A):</strong> {{ Str::upper($workshop->user->name) }}</td>
            <td><strong>COORDENADOR(A):</strong> {{ Str::upper($workshop->academicCoordination->coordinator) }}</td>
        </tr>
    </table>

    @if($lessons->isEmpty())
        <p class="title">
            <strong>Não há aulas registradas neste mês.</strong>
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
                    <tr>
                        <td>{{$key + 1}}</td>
                        <td style="text-align: left;">{{ $student->name }}</td>
                        @foreach($lessons as $lesson)
                            <td></td>
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layout-report>