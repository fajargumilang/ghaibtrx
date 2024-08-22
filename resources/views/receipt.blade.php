<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            color: #000;
            margin: 0;
            padding: 0;
        }

        .receipt-container {
            width: 80mm;
            /* Ukuran 80mm */
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            background: #fff;
            height: auto;
        }

        .receipt-header,
        .footer {
            text-align: center;
            font-size: 12px;
        }

        .under-header {
            text-align: left;
            font-size: 12px;
        }

        .receipt-header h4,
        .receipt-header h5 {
            margin: 0;
            font-weight: bold;
        }

        .dashed {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .items-table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            padding: 2px;
            text-align: left;
        }

        .total {
            text-align: right;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
        }
    </style>
</head>

<body>
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
                {{ $receipt->kassa }}-{{ $receipt->name_of_kassa }}{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('d.m.Y') }}
                [{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i') }}]</div>
        </div>

        <div class="dashed"></div>

        <table class="items-table">
            @foreach ($receipt->items as $item)
                <tr>
                    <td colspan="3" class="text-uppercase">{{ $item->product_name }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="text-uppercase">{{ $item->quantity }},00 X
                        {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="total text-uppercase"> : {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <div class="dashed"></div>

        <table class="items-table">
            <tr>
                <td class="text-uppercase">Item : {{ $totalItems }}</td>
                <td class="">TOTAL</td>
                <td class="total">: Rp {{ number_format($receipt->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-uppercase"></td>
                <td class="">TUNAI</td>
                <td class="total">: Rp {{ number_format($receipt->uang_tunai, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-uppercase">Qty : {{ $totalQuantity }}</td>
                <td class="">KEMBALI</td>
                <td class="total">: Rp {{ number_format($receipt->uang_tunai - $receipt->total_amount, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <table class="items-table mb-2">
            <tr>
                <td class="text-uppercase">ANDA HEMAT : RP {{ $receipt->tunai ?? 0 }}</td>
            </tr>
        </table>

        <table class="items-table mb-3">
            <tr>
                <td class="text-uppercase">MEMBER</td>
                <td>:</td>
                <td class="text-uppercase">{{ $receipt->member ?? 0 }}</td>
            </tr>
            <tr>
                <td class="text-uppercase">NAMA</td>
                <td>:</td>
                <td class="text-uppercase">{{ $receipt->name_of_customer ?? '-' }}</td>
            </tr>
            <tr>
                <td class="text-uppercase">PT.AKHIR</td>
                <td>:</td>
                <td class="text-uppercase">{{ $receipt->pt_akhir ?? 0 }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>-= TERIMA KASIH ATAS KUNJUNGAN ANDA =-</p>
            <p>DONASI DIISALURKAN MELALUI BMH</p>
        </div>
        <div class="dashed"></div>

        <table class="items-table">
            <tr>
                <td class="text-uppercase">KASSA</td>
                <td>:</td>
                <td class="float-right text-uppercase">
                    {{ \Carbon\Carbon::parse($receipt->time_transaction)->format('d.m.Y') }}
                    [{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i') }}]</td>
            </tr>
            <tr>
                <td class="text-uppercase">MEMBER</td>
                <td>:</td>
                <td colspan="2" class="text-uppercase">{{ $receipt->name_of_customer ?? '-' }}</td>
            </tr>
        </table>
        <div class="dashed"></div>
        <table class="items-table">
            <tr>
                <td class="text-uppercase">BELANJA MINIMAL 250.000</td>
                <td>:</td>
                <td class="float-right"> {{ number_format($receipt->total_amount, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td class="text-uppercase">KUPON GEBYAR {{ $receipt->store_name }} {{ $currentYear }} </td>
                <td>:</td>
                <td class="float-right text-uppercase"> {{ intval($receipt->total_amount / 250000) }}</td>
            </tr>
        </table>
        <div class="dashed"></div>

    </div>
</body>

</html>
