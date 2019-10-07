@extends('pdf.layout')

@section('content')
<table class="table table-striped">
    <caption class="heading">{{ ucfirst($printer->model) }} ({{ $printer->ink->type }}) Colors</caption>
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
                <td>{{ $color->name }}</td>
                <td>{{ $color->pivot->approved ? 'yes' : 'no' }}</td>
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
