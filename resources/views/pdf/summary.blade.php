@extends('pdf.layout')

@section('content')

@foreach($summary as $type => $report)
<table class="table table-striped">
    <caption class="heading">{{ ucfirst($type) }} Orders for {{ $date }}</caption>
    <thead>
        <tr>
            <th>Schedule</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @forelse($report['summary'] as $week => $amount)
            <tr>
                <td>{{ $week }}</td>
                <td>{{ $amount }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="2"><b>There are no undelivered late orders.</b></td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><b>Total: {{ $report['total']}}</b></td>
        </tr>
    </tfoot>
</table>
@endforeach

@endsection
