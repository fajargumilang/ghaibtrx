@extends('layout.backend.app', [
    'title' => 'Receipt Print',
    'pageTitle' => 'Receipt Print',
])

@push('css')
    <link href="{{ asset('template/backend/sb-admin-2') }}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @elseif($message = Session::get('error'))
        <div class="alert alert-danger" role="alert">
            <div class="alert-body">
                <strong>{{ $message }}</strong>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    @endif
    <div class="notify"></div>
    <div class="card">
        <div class="card-header">
            <!-- Button trigger modal -->
            <a href="{{ route('receipts.create') }}" class="btn btn-primary">
                Create Receipt
            </a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Receipt Number</th>
                            <th>Total Amount</th>
                            <th>Discount</th>
                            <th>Tax</th>
                            <th>Final Amount</th>
                            <th>Payment Method</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($receipts as $receipt)
                            <tr>
                                <td>{{ $receipt->receipt_number }}</td>
                                <td>Rp {{ number_format($receipt->total_amount, 2) }}</td>
                                <td>Rp {{ number_format($receipt->discount, 2) }}</td>
                                <td>Rp {{ number_format($receipt->tax, 2) }}</td>
                                <td>Rp {{ number_format($receipt->final_amount, 2) }}</td>
                                <td>{{ ucfirst($receipt->payment_method) }}</td>
                                <td>{{ $receipt->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('receipts.edit', $receipt->id) }}"
                                        class="btn btn-success btn-sm">Edit</a>

                                    <a href="{{ route('receipts.show', $receipt->id) }}"
                                        class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
