<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use ErrorException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Product::select('*')->orderBy('created_at', 'DESC');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="row"><a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-primary btn-sm ml-2 btn-edit">Edit</a>';
                        $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm ml-2 btn-delete">Delete</a></div>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Error: ' . $e->getMessage()], 500);
            }
        }

        return view('admin.product.index');
    }



    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'product_name' => 'required|unique:products,name',
                'price' => 'required|numeric',
                'description' => 'required',
            ], [
                'product_name.unique' => 'Nama produk sudah ada, silakan gunakan nama lain.',
            ]);

            Product::create([
                'name' => $request->product_name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product ' . $request->product_name . '  created successfully!');
        } catch (ErrorException $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat produk.');
        }
    }


    public function destroy($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::find($id);

        // Pastikan produk ditemukan sebelum dihapus
        if (!$product) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // Hapus produk
        $product->delete();

        // Jika berhasil, kembalikan response sukses
        return response()->json(['success' => 'Product ' . $product->name . ' deleted successfully']);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:1000',
        ]);
        $product = Product::find($id);
        if ($product) {
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->description = $request->input('description');
            $product->save();

            return response()->json(['success' => 'Product ' . $product->name . ' updated successfully']);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
}
