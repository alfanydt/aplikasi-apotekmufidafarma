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
                ->paginate($pagination)
                ->withQueryString();
        } else {
            $products = Product::select('id', 'category_id', 'name', 'price', 'image')->with('category:id,name')
                ->with('stocks')
                ->latest()
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
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
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
}
