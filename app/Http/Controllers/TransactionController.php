<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $transactions = Transaction::with('product')
            ->when($search, function ($query, $search) {
                $query->whereHas('product', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::with('stocks')->get(['id', 'name', 'harga_satuan']);
        return view('transactions.create', compact('products'));
    }

    public function productSearch(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        $products = Product::where('name', 'like', '%' . $query . '%')
            ->limit(10)
            ->get(['id', 'name']);

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_data'     => 'required|json',
            'total_payment' => 'required|numeric',
            'amount_paid'   => 'required|numeric|min:0',
        ]);

        if ($request->amount_paid < $request->total_payment) {
            return redirect()->back()
                ->withErrors(['amount_paid' => 'Jumlah yang dibayarkan tidak boleh kurang dari total pembayaran.'])
                ->withInput();
        }

        $cartData = json_decode($request->input('cart_data'), true);

        if (!$cartData || !is_array($cartData)) {
            return redirect()->back()->withErrors(['cart_data' => 'Data keranjang tidak valid.'])->withInput();
        }

        // Generate transaction batch ID untuk mengelompokkan transaction yang sama
        $batchId = uniqid('TRX_');
        
        \DB::beginTransaction();
        try {
            foreach ($cartData as $item) {
                if (
                    !isset($item['id'], $item['quantity'], $item['price']) ||
                    !is_numeric($item['price']) ||
                    !is_numeric($item['quantity'])
                ) {
                    \DB::rollBack();
                    return redirect()->back()->withErrors(['cart_data' => 'Item keranjang tidak valid.'])->withInput();
                }

                // Validasi stok
                $productStock = \App\Models\ProductStock::where('product_id', $item['id'])->first();

                if (!$productStock) {
                    \DB::rollBack();
                    return redirect()->back()->withErrors(['stock' => 'Stok produk tidak ditemukan'])->withInput();
                }

                if ($productStock->jumlah_obat < $item['quantity']) {
                    \DB::rollBack();
                    return redirect()->back()->withErrors(['stock' => 'Stok produk tidak cukup untuk ' . $item['name']])->withInput();
                }

                // Buat transaksi dengan batch_id untuk mengelompokkan
                Transaction::create([
                    'product_id'   => $item['id'],
                    'qty'          => $item['quantity'],
                    'total'        => $item['price'] * $item['quantity'],
                    'amount_paid'  => $request->amount_paid,
                    'date'         => now(),
                    'batch_id'     => $batchId, // Tambahkan ini ke migration jika belum ada
                ]);

                // Update stok
                $productStock->jumlah_obat -= $item['quantity'];
                $productStock->save();
            }

            \DB::commit();
            
            // Redirect ke halaman invoice dengan batch_id
            return redirect()->route('transactions.invoice', $batchId)
                ->with('success', 'Transaksi berhasil disimpan! Silakan cetak struk.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $transaction = Transaction::with('product')->findOrFail($id);
        $products = Product::get(['id', 'name', 'harga_satuan']);
        return view('transactions.edit', compact('transaction', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date'       => 'required|date',
            'product_id' => 'required|exists:products,id',
            'qty'        => 'required|numeric|min:1',
            'total'      => 'required|numeric',
            'amount_paid'=> 'required|numeric|min:0',
        ]);

        $transaction = Transaction::findOrFail($id);

        // Kembalikan stok lama
        $oldProductStock = \App\Models\ProductStock::where('product_id', $transaction->product_id)->first();
        if ($oldProductStock) {
            $oldProductStock->jumlah_obat += $transaction->qty;
            $oldProductStock->save();
        }

        // Update transaksi
        $transaction->update([
            'product_id'  => $request->product_id,
            'qty'         => $request->qty,
            'total'       => $request->total,
            'amount_paid' => $request->amount_paid,
            'date'        => $request->date,
        ]);

        // Kurangi stok baru
        $newProductStock = \App\Models\ProductStock::where('product_id', $request->product_id)->first();
        if ($newProductStock) {
            if ($newProductStock->jumlah_obat < $request->qty) {
                return redirect()->back()->withErrors(['stock' => 'Stok produk tidak cukup'])->withInput();
            }
            $newProductStock->jumlah_obat -= $request->qty;
            $newProductStock->save();
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        // Kembalikan stok sebelum hapus transaksi
        $productStock = \App\Models\ProductStock::where('product_id', $transaction->product_id)->first();
        if ($productStock) {
            $productStock->jumlah_obat += $transaction->qty;
            $productStock->save();
        }
        
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus dan stok dikembalikan.');
    }

    // Jika ingin invoice untuk batch transaction
    public function invoice($batchId)
    {
        $transactions = Transaction::with('product')
            ->where('batch_id', $batchId)
            ->get();
            
        if ($transactions->isEmpty()) {
            abort(404, 'Transaction not found');
        }
        
        return view('transactions.invoice', compact('transactions'));
    }
}