<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\ReceiptItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


use ErrorException;
use Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mpdf\Mpdf;


class ReceiptController extends Controller
{

    function generateUniqueReceiptNumber()
    {
        do {
            // Kombinasi angka, huruf, dan timestamp
            $receiptNumber = 'REC-' . date('YmdHis') . '-' . Str::upper(Str::random(4));

            // Cek apakah nomor resi sudah ada di database
            $exists = Receipt::where('receipt_number', $receiptNumber)->exists();
        } while ($exists);

        return $receiptNumber;
    }

    public function index()
    {
        $receipts = Receipt::orderBy('created_at', 'desc')->get();
        return view('admin.receipts.index', compact('receipts'));
    }

    public function edit($id)
    {
        $receipt = Receipt::with('items')->findOrFail($id);
        $products = Product::all();

        return view('admin.receipts.edit', compact('receipt', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required',
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'hp' => 'required|string|max:15',
            'trans' => 'required|numeric',
            'kassa' => 'required|string|max:255',
            'time_transaction' => 'required|date_format:H:i',
            'tanggal' => 'required|date',
            'anda_hemat' => 'nullable|string|max:15',
            // Informations
            'name_of_kassa' => 'required|string|max:255',
            'uang_tunai' => 'required|string|max:255',

            'member' => 'nullable|string|max:255',
            'name_of_customer' => 'nullable|string|max:255',
            'pt_akhir' => 'nullable|string|max:255',
            // Product details
            'product_name.*' => 'required|string|max:255',
            'price.*' => 'required|numeric|min:0',
            'quantity.*' => 'required|integer|min:1',
            // 'deleted_items' => 'nullable|array',
            // 'deleted_items.*' => 'exists:receipt_items,id',
        ]);

        $deletedItems = $request->input('deleted_items');
        $deletedItems = json_decode($deletedItems, true); // Mengonversi string JSON menjadi array PHP
        if (!empty($deletedItems)) {
            ReceiptItem::whereIn('product_name', $deletedItems)->delete();
        }

        $receipt = Receipt::findOrFail($id);
        // Process the deleted items (if any)

        $receipt->update([
            'receipt_number' => $this->generateUniqueReceiptNumber(),
            'tanggal' => $request->tanggal,
            'store_name' => $request->store_name,
            'address' => $request->address,
            'hp' => $request->hp,
            'trans' => $request->trans,
            'kassa' => $request->kassa,
            'time_transaction' => $request->time_transaction,
            'member' => $request->member,
            'name_of_kassa' => $request->name_of_kassa,
            'name_of_customer' => $request->name_of_customer,
            'pt_akhir' => $request->pt_akhir,
            'payment_method' => $request->payment_method,
            'uang_tunai' => $request->uang_tunai,
            'anda_hemat' => $request->anda_hemat,
        ]);

        $receiptItems = ReceiptItem::where('receipt_id', $id)->get();
        $totalAmount = 0;

        foreach ($request->product_name as $key => $productName) {
            $item = ReceiptItem::where('receipt_id', $id)
                ->where('product_name', $productName)
                ->first();

            if (!$item) {
                $item = new ReceiptItem(['receipt_id' => $id]);
            }

            $product = Product::where('name', $productName)->first();

            if ($product) {
                $calculatedPrice = $product->price * $request->quantity[$key];

                $item->fill([
                    'product_name' => $productName,
                    'quantity' => $request->quantity[$key],
                    'price' => $product->price,
                    'total_price' => $calculatedPrice,
                ]);

                $item->save();

                $totalAmount += $calculatedPrice;
            }
        }

        $discount = $request->discount ?? 0;
        $tax = $request->tax ?? 0;

        // Hitung diskon dan pajak berdasarkan totalAmount
        $discountCalculate = $discount > 0 ? ($totalAmount * $discount / 100) : 0;
        $taxCalculate = $tax > 0 ? ($totalAmount * $tax / 100) : 0;

        // Hitung finalAmount setelah mengurangi diskon dan menambah pajak
        $finalAmount = ($totalAmount - $discountCalculate) + $taxCalculate;

        $receipt->update([
            'total_amount' => $totalAmount,
            'discount' => $discount,
            'tax' => $tax,
            'final_amount' => $finalAmount,
        ]);

        return redirect()->route('receipts.index')->with('success', 'Receipt ' . $receipt->receipt_number . ' updated successfully.');
    }

    public function create()
    {
        $products = Product::all();
        return view(
            'admin.receipts.create',
            compact(
                'products'
            )
        );
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // Validasi data
            $this->validate($request, [
                // Store data
                'payment_method' => 'required',
                'store_name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'hp' => 'required|string|max:15',
                'trans' => 'required|numeric',
                'kassa' => 'required|string|max:255',
                'time_transaction' => 'required|date_format:H:i',
                'tanggal' => 'required|date',
                'anda_hemat' => 'nullable|string|max:15',
                // Informations
                'name_of_kassa' => 'required|string|max:255',
                'uang_tunai' => 'required|string|max:255',

                'member' => 'nullable|string|max:255',
                'name_of_customer' => 'nullable|string|max:255',
                'pt_akhir' => 'nullable|string|max:255',
                // Product details
                'product_name.*' => 'required|string|max:255',
                'price.*' => 'required|numeric|min:0',
                'quantity.*' => 'required|integer|min:1',
            ]);

            // Buat receipt terlebih dahulu untuk mendapatkan receipt_id
            $receipt = Receipt::create([
                'receipt_number' => $this->generateUniqueReceiptNumber(),
                'store_name' => $request->store_name,
                'tanggal' => $request->tanggal,
                'address' => $request->address,
                'hp' => $request->hp,
                'trans' => $request->trans,
                'kassa' => $request->kassa,
                'time_transaction' => $request->time_transaction,
                'member' => $request->member,
                'name_of_kassa' => $request->name_of_kassa,
                'name_of_customer' => $request->name_of_customer,
                'pt_akhir' => $request->pt_akhir,
                'payment_method' => $request->payment_method,
                'uang_tunai' => $request->uang_tunai,
                'anda_hemat' => $request->anda_hemat,
                // 'total_amount' dan 'final_amount' akan di-update setelah loop
            ]);


            $totalAmount = 0; // Inisialisasi total amount
            foreach ($request->product_name as $index => $name) {
                $totalPrice = $request->price[$index] * $request->quantity[$index];

                $totalAmount += $totalPrice;

                ReceiptItem::create([
                    'receipt_id' => $receipt->id,
                    'product_name' => $name,
                    'price' => $request->price[$index],
                    'quantity' => $request->quantity[$index],
                    'total_price' => $totalPrice,
                ]);
            }

            $discount = $request->discount ?? 0;
            $tax = $request->tax ?? 0;

            // Pastikan diskon dan pajak tidak nol untuk menghindari division by zero
            $discountCalculate = $discount > 0 ? ($totalAmount * $discount / 100) : 0;
            $taxCalculate = $tax > 0 ? ($totalAmount * $tax / 100) : 0;

            // Hitung finalAmount setelah menghitung diskon dan pajak
            $finalAmount = ($totalAmount - $discountCalculate) + $taxCalculate;

            $receipt->update([
                'total_amount' => $totalAmount,
                'discount' => $discount,
                'tax' => $tax,
                'final_amount' => $finalAmount,
            ]);

            DB::commit();
            return redirect()->route('receipts.index')->with('success', 'Receipt created successfully!');
        } catch (ErrorException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'error gan.');
        }
    }

    public function show($id)
    {
        $receipt = Receipt::with('items')->findOrFail($id);
        $totalQuantity = $receipt->items->sum('quantity');
        $totalItems = $receipt->items->count('id');

        $currentYear = Carbon::now()->year;

        return view('admin.receipts.show', compact(
            'receipt',
            'totalQuantity',
            'totalItems',
            'currentYear'
        ));
    }


    public function downloadReceipt($id)
    {
        $receipt = Receipt::with('items')->findOrFail($id);
        $totalQuantity = $receipt->items->sum('quantity');
        $totalItems = $receipt->items->count();
        $currentYear = Carbon::now()->year;

        $data = [
            'receipt' => $receipt,
            'totalItems' => $totalItems,
            'totalQuantity' => $totalQuantity,
            'currentYear' => $currentYear,
        ];

        // Render view ke HTML
        $html = view('receipt', $data)->render();

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [80, 9999], // Lebar 80mm, tinggi sementara 9999mm
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'autoPageBreak' => false,
        ]);

        $mpdf->WriteHTML($html);

        // === Hitung tinggi konten ===
        // $mpdf->y adalah posisi vertical saat render selesai
        // tMargin dan bMargin adalah margin atas dan bawah (yang sudah 0 di sini)
        $contentHeight = $mpdf->y + $mpdf->tMargin + $mpdf->bMargin;

        // === Render Kedua: Gunakan tinggi yang baru agar kertas hanya sesuai dengan isi ===
        $mpdf2 = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [80, $contentHeight],
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
            'autoPageBreak' => false,
        ]);

        $mpdf2->WriteHTML($html);

        return response()->stream(
            function () use ($mpdf2) {
                $mpdf2->Output('receipt.pdf', 'D');
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="receipt.pdf"',
            ]
        );
    }
}
