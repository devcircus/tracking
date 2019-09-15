@extends('pdf.layout')

@section('content')
<table class="table table-striped">
    <caption class="heading">Sublimation Fabrics</caption>
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Manufacturer</th>
            <th>Cross-Grain</th>
            <th>Press Speed</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fabrics as $fabric)
            <tr>
                <td>{{ $fabric->code }}</td>
                <td>{{ $fabric->name }}</td>
                <td>{{ $fabric->manufacturer }}</td>
                <td>{{ $fabric->cross_grain ? 'yes' : 'no'}}</td>
                <td>{{ $fabric->press_speed }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">Something went wrong.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@stop
