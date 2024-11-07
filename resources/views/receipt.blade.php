<!DOCTYPE html>
<html>

<head>
    <style>
        html,
        body {

            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Courier', Courier, monospace;

            color: #000;
            margin: 0;
            padding: 0;
        }


        .text-uppercase {
            text-transform: uppercase;
        }

        .float-right {
            float: right;
        }

        .receipt-container {
            page-break-inside: avoid;
            /* Prevent page breaks inside container */
            overflow: hidden;
            /* Prevent overflow issues */
        }

        table {
            border-collapse: collapse;
            /* Ensure no extra space around table */
        }

        td,
        th {
            border: none;
            /* Ensure no border causing extra space */
            padding: 0;
            /* Remove padding if causing extra space */
        }



        .receipt-container {
            /* Ukuran 80mm */
            width: 80mm;
            /* Make sure container width matches PDF width */
            margin: 0 auto;
            padding: 10px;
            border: 0px solid #000;
            background: #fff;
            height: auto;
            /* Ensure the container height adapts to content */

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
            padding: 0px 0px 2px 0px;
            text-align: left;
        }

        .total {
            text-align: right;
        }

        .footer p {
            margin: 0;
            font-size: 12px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    @php
        // Fungsi untuk menambahkan spasi setiap 4 digit
        function formatPhoneNumber($number)
        {
            return implode(' ', str_split($number, 4));
        }

        $formattedHp = formatPhoneNumber($receipt->hp);
    @endphp

    <div class="receipt-container">
        <div class="receipt-header">
            <div class="text-uppercase">{{ strtoupper($receipt->store_name) }}</div>
            <div class="text-uppercase">Your Shopping Partner</div>
            <br>
            <div class="text-uppercase">{{ strtoupper($receipt->address) }}</div>

            <div class="text-uppercase">HP: {{ $formattedHp }}</div>
        </div>

        <div class="dashed"></div>
        <div class="under-header">
            <div class="text-uppercase">TRANS: {{ $receipt->kassa }}-{{ $receipt->trans }}</div>
            <div class="text-uppercase">KASSA:
                {{ $receipt->kassa }}-{{ $receipt->name_of_kassa }}{{ $receipt->tanggal ? \Carbon\Carbon::parse($receipt->tanggal)->format('d.m.Y') : ($receipt->time_transaction ? \Carbon\Carbon::parse($receipt->time_transaction)->format('d.m.Y') : '') }}
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
                </tr>
                <tr>
                    <td></td>
                    <td class="text-uppercase float-right">{{ $item->quantity }},00 X
                        {{ $qtyRp }}{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>:</td>
                    <td class="text-right text-uppercase" style="text-align: right;">
                        {{ number_format($item->total_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </table>
        <div class="dashed"></div>

        <table class="items-table" style="margin-bottom:0.5rem;">
            <tr>
                <td class="">Item : {{ $totalItems }}</td>
                <td class="" style="text-align: left;">TOTAL</td>
                <td class="" style="text-align: left;">:Rp</td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format($receipt->total_amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-uppercase"></td>
                <td class="" style="text-align: left;">TUNAI</td>
                <td class="" style="text-align: left;">:Rp</td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format($receipt->uang_tunai, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="">Qty : {{ $totalQuantity }}</td>
                <td class="" style="text-align: left;">KEMBALI</td>
                <td class="" style="text-align: left;">:Rp</td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format($receipt->uang_tunai - $receipt->total_amount, 0, ',', '.') }}
                </td>
            </tr>
        </table>

        <table class="items-table mb-2" style="margin-bottom:0.5rem;">
            <tr>
                <td class="text-uppercase">ANDA HEMAT : RP {{ $receipt->anda_hemat ?? 0 }}</td>
            </tr>
        </table>

        @if ($receipt->member == !null || $receipt->name_of_customer == !null || $receipt->pt_akhir == !null)
            <table class="items-table mb-3" style="margin-bottom:0.5rem;">
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
        @endif

        <div class="footer" style="margin-bottom:0.5rem;">
            <p>-= TERIMA KASIH ATAS KUNJUNGAN ANDA =-</p>
            <p>DONASI DISALURKAN MELALUI BMH</p>
        </div>
        <div class="dashed"></div>

        <table class="items-table">
            <tr>
                <td class="text-uppercase">KASSA</td>
                <td>:</td>
                <td class="text-right text-uppercase" style="text-align: right;">
                    {{ \Carbon\Carbon::parse($receipt->time_transaction)->format('d.m.y') }}
                    [{{ \Carbon\Carbon::parse($receipt->time_transaction)->format('H:i') }}]</td>
            </tr>
            @if ($receipt->name_of_customer == !null)
                <tr>
                    <td class="text-uppercase">MEMBER</td>
                    <td>:</td>
                    <td colspan="2" class="text-uppercase">{{ $receipt->name_of_customer }}</td>
                </tr>
            @endif
        </table>
        <div class="dashed"></div>
        <table class="items-table">
            <tr>
                <td class="text-uppercase">BELANJA MINIMAL 250.000</td>
                <td>:</td>
                <td class="text-right" style="text-align: right;">
                    {{ number_format($receipt->total_amount, 0, ',', '.') }} </td>
            </tr>
            <tr>
                <td class="text-uppercase">KUPON GEBYAR {{ $receipt->store_name }} {{ $currentYear }} </td>
                <td>:</td>
                <td class="text-right text-uppercase" style="text-align: right;">
                    {{ intval($receipt->total_amount / 250000) }}</td>
            </tr>
        </table>

    </div>
</body>

</html>
