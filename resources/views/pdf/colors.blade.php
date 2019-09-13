@extends('pdf.layout')

@section('content')
<table class="table table-striped">
    <caption class="heading">{{ ucfirst($printer->name) }} Colors ({{ $printer->ink->type }})</caption>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Approved</th>
            <th>CMYK</th>
        </tr>
    </thead>
    <tbody>
        @forelse($colors as $color)
            <tr>
                <td>{{ $color->code }}</td>
                <td>{{ $color->type }}</td>
                <td>{{ $color->pivot->approved }}</td>
                <td>{{ $color->pivot->cyan }}-{{ $color->pivot->magenta }}-{{ $color->pivot->yellow }}-{{ $color->pivot->black }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Something went wrong.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@stop
