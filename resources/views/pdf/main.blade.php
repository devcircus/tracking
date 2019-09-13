@extends('pdf.layout')

@section('content')
<table class="table table-striped">
    <caption class="heading">{{ ucfirst($type) }} Orders</caption>
    <thead>
        <tr>
            <th>Schedule Date</th>
            <th>Order</th>
            <th>Voucher</th>
            <th>Customer</th>
            <th>Style</th>
            <th>Quantity</th>
            <th style="width:200px">Notes</th>
        </tr>
    </thead>
    <tbody>
        @forelse($report as $voucher)
            <tr>
                <td>{{ $voucher->schedule_date }}</td>
                <td>{{ $voucher->order_number }}</td>
                <td>{{ $voucher->voucher }}</td>
                <td>{{ $voucher->customer }}</td>
                <td>{{ $voucher->style }}</td>
                <td>{{ $voucher->quantity }}</td>
                @if('prototype' === $type)
                    <td>{{ $voucher->info }}</td>
                @else
                    <td>&nbsp;</td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="7">There are no undelivered late orders.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
