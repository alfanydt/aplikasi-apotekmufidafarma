<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request): View
    {
        $pagination = $request->input('perPage', 10);

        if ($request->search) {
            $products = Product::select('id', 'category_id', 'name', 'price', 'image')->with('category:id,name')
                ->where(function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->search . '%')
                          ->orWhere('price', 'LIKE', '%' . $request->search . '%');
                })
                ->with('stocks')
                ->orderBy('name', 'asc')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            $products = Product::select('id', 'category_id', 'name', 'price', 'image')->with('category:id,name')
                ->with('stocks')
                ->orderBy('name', 'asc')
                ->paginate($pagination);
        }

        return view('products.index', compact('products'))->with('i', ($request->input('page', 1) - 1) * $pagination)->with('perPage', $pagination);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::get(['id', 'name']);
        $suppliers = \App\Models\Supplier::get(['id', 'name']);
        return view('products.create', compact('categories', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
            'supplier'    => 'required|exists:suppliers,id',
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
            'harga_satuan'=> 'required',
            'jumlah_obat' => 'required|integer|min:0',
            'expired_obat'=> 'required|date',
            'image'       => 'required|image|mimes:jpeg,jpg,png|max:1024'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        $product = Product::create([
            'category_id' => $request->category,
            'supplier_id' => $request->supplier,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => str_replace('.', '', $request->price),
            'harga_satuan'=> str_replace('.', '', $request->harga_satuan),
            'image'       => $image->hashName()
        ]);

        $product->stocks()->create([
            'jumlah_obat' => $request->jumlah_obat,
            'expired_obat'=> $request->expired_obat,
        ]);

        return redirect()->route('products.index')->with(['success' => 'The new product has been saved.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $product = Product::findOrFail($id);
        $categories = Category::get(['id', 'name']);
        $suppliers = \App\Models\Supplier::get(['id', 'name']);
        return view('products.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
            'supplier'    => 'required|exists:suppliers,id',
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
            'harga_satuan'=> 'required',
            'jumlah_obat' => 'required|integer|min:0',
            'expired_obat'=> 'required|date',
            'image'       => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);

        $product = Product::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            Storage::delete('public/products/' . $product->image);

            $product->update([
                'category_id' => $request->category,
                'supplier_id' => $request->supplier,
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => str_replace('.', '', $request->price),
                'harga_satuan'=> str_replace('.', '', $request->harga_satuan),
                'image'       => $image->hashName()
            ]);
        } else {
            $product->update([
                'category_id' => $request->category,
                'supplier_id' => $request->supplier,
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => str_replace('.', '', $request->price),
                'harga_satuan'=> str_replace('.', '', $request->harga_satuan)
            ]);
        }

        $product->stocks()->updateOrCreate(
            [],
            [
                'jumlah_obat' => $request->jumlah_obat,
                'expired_obat'=> $request->expired_obat,
            ]
        );

        return redirect()->route('products.index')->with(['success' => 'The product has been updated.']);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = Product::with('stocks')
            ->where('name', 'LIKE', "%$query%")
            ->take(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $product = Product::findOrFail($id);

        Storage::delete('public/products/' . $product->image);

        $product->delete();

        return redirect()->route('products.index')->with(['success' => 'The product has been deleted!']);
    }
}
