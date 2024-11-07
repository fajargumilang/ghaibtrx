@extends('layout.backend.app', [
    'title' => 'Receipt View',
])
@php
    use Carbon\Carbon;
@endphp


@push('css')
    <style>
        body {
            font-family: 'Courier', Courier, monospace;
            color: #000;
        }

        .receipt-container {
            /* Atur sesuai dengan ukuran kertas thermal */
            width: 100mm;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            background: #fff;
            height: auto;
        }

        .receipt-header,
        .footer {
            text-align: center;
            font-size: 16px;
        }

        .under-header {
            text-align: left;
            font-size: 16px;
        }

        .receipt-header h4,
        .receipt-header h5 {
            margin: 0;
            font-weight: bold;
        }

        .dashed {
            border-top: 2px dashed #000;
            margin: 10px 0;
        }

        .items-table {
            width: 100%;
            font-size: 16px;
        }

        .items-table th,
        .items-table td {
            padding: 0;
            text-align: left;
        }

        .total {
            text-align: right;
        }

        .footer p {
            margin: 0;
        }

        /* CSS khusus untuk mode cetak */
        @media print {

            /* Sembunyikan elemen yang tidak ingin dicetak */
            body * {
                visibility: hidden;
            }

            /* Pastikan hanya .receipt-container yang terlihat */
            .receipt-container,
            .receipt-container * {
                visibility: visible;
            }

            /* Atur posisi .receipt-container untuk muncul di bagian atas halaman */
            .receipt-container {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 100mm;
                height: auto;
                margin: 0;
                padding: 0;
                border: none;
            }
        }
    </style>
@endpush


@section('content')
    <button onclick="window.print()" class="btn btn-primary">Print</button>
    <a href="{{ route('receipts.download', ['id' => $receipt->id]) }}" class="btn btn-info">Download Receipt</a>
    <a href="{{ route('receipts.index') }}" class="btn btn-danger">Back</a>


    <div class="receipt-container">
        <div class="receipt-header">
            <div class="text-uppercase">{{ strtoupper($receipt->store_name) }}</div>
            <div class="text-uppercase">Your Shopping Partner</div>
            <br>
            <div class="text-uppercase">{{ strtoupper($receipt->address) }}</div>
            <div class="text-uppercase">HP: {{ $receipt->hp }}</div>
        </div>
        <div class="dashed"></div>
        <div class="under-header">
            <div class="text-uppercase">TRANS: {{ $receipt->kassa }}-{{ $receipt->trans }}</div>
            <div class="text-uppercase">KASSA:
                {{ $receipt->kassa }}-{{ $receipt->name_of_kassa }}{{ $receipt->tanggal ? \Carbon\Carbon::parse($receipt->tanggal)->format('d.m.Y') : '' }}
                [{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i') }}]</div>

        </div>

        <div class="dashed"></div>
        @php
            $qtyRp = '@';
        @endphp

        <table class="items-table">
            @foreach ($receipt->items as $item)
                <tr>
                    <td colspan="3" class="text-uppercase">{{ $item->product_name }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-uppercase">{{ $item->quantity }},00 X
                        {{ $qtyRp }}{{ number_format($item->price, 0, ',', '.') }}</td>
                    </td>
                    <td>:</td>
                    <td class="float-right text-uppercase"> {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <div class="dashed"></div>

        @php
            $kembalian = $receipt->uang_tunai - $receipt->total_amount;
        @endphp
        <table class="items-table">
            <tr>
                <td class="">Item : {{ $totalItems }}</td>
                <td class="">TOTAL</td>
                <td class="">:Rp </td>
                <td class="float-right"> {{ number_format($receipt->total_amount, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td class="text-uppercase"></td>
                <td class="">TUNAI</td>
                <td class="">:Rp</td>
                <td class="float-right"> {{ number_format($receipt->uang_tunai, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td class="">Qty : {{ $totalQuantity }}</td>
                <td class="">KEMBALI</td>
                <td class="">:Rp</td>
                <td class="float-right"> {{ number_format($kembalian, 0, ',', '.') }} </td>
            </tr>
        </table>

        <table class="items-table mb-2">
            <tr>
                {{-- //NOT FUNCTION --}}
                <td class="text-uppercase">ANDA HEMAT : RP {{ $receipt->anda_hemat ?? 0 }}</td>
            </tr>
        </table>

        @if ($receipt->member == !null || $receipt->name_of_customer == !null || $receipt->pt_akhir == !null)
            <table class="items-table mb-3">
                <tr>
                    <td class="text-uppercase">MEMBER</td>
                    <td class=""> :</td>
                    <td class="text-uppercase"> {{ $receipt->member ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="text-uppercase">NAMA </td>
                    <td class=""> :</td>
                    <td class="text-uppercase"> {{ $receipt->name_of_customer ?? '-' }}</td>

                </tr>
                <tr>
                    <td class="text-uppercase">PT.AKHIR </td>
                    <td>:</td>
                    <td class="text-uppercase">{{ $receipt->pt_akhir ?? '-' }}</td>
                </tr>
            </table>
        @endif

        <div class="footer">
            <p>-=TERIMA KASIH ATAS KUNJUNGAN ANDA=-</p>
            <p>DONASI DISALURKAN MELALUI BMH</p>
        </div>
        {{-- <p>Payment Method: {{ ucfirst($receipt->payment_method) }}</p> --}}
        <div class="dashed"></div>

        <table class="items-table">
            <tr>
                <td class="text-uppercase">KASSA</td>
                <td class="">:</td>
                <td></td>
                <td class="float-right text-uppercase">
                    {{ \Carbon\Carbon::parse($receipt->time_transaction)->format('d.m.y') }}

                    [{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i') }}]
                </td>
            </tr>
            @if ($receipt->name_of_customer == !null)
                <tr>
                    <td class="text-uppercase">MEMBER </td>
                    <td class="">:</td>
                    <td colspan="2" class="text-uppercase"> {{ $receipt->name_of_customer ?? '-' }}</td>
                    <td></td>
                </tr>
            @endif
        </table>
        <div class="dashed"></div>
        <table class="items-table">
            <tr>
                {{-- //NOT FUNCTION --}}
                <td class="text-uppercase">BELANJA MINIMAL 250.000</td>
                <td>:</td>
                <td class="float-right"> {{ number_format($receipt->total_amount, 0, ',', '.') }} </td>

            </tr>
            <tr>
                {{-- //NOT FUNCTION --}}
                <td class="text-uppercase">KUPON GEBYAR {{ $receipt->store_name }} {{ $currentYear }} </td>
                <td>:</td>
                <td class="float-right text-uppercase"> {{ intval($receipt->total_amount / 250000) }}
                </td>
            </tr>
        </table>
    </div>
@endsection
