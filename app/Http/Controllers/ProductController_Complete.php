<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Import products from Excel file.
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('excel_file');

        $rows = Excel::toArray([], $file);

        if (count($rows) == 0 || count($rows[0]) == 0) {
            return redirect()->back()->withErrors(['excel_file' => 'The Excel file is empty or invalid.']);
        }

        $header = $rows[0][0];
        $expectedHeader = ['category_id', 'name', 'description', 'price', 'harga_satuan', 'jumlah_obat', 'expired_obat', 'image_url'];

        $headerLower = array_map('strtolower', $header);
        $expectedLower = array_map('strtolower', $expectedHeader);
        if ($headerLower !== $expectedLower) {
            return redirect()->back()->withErrors(['excel_file' => 'The Excel file header does not match the expected format. Expected columns: ' . implode(', ', $expectedHeader)]);
        }

        $dataRows = array_slice($rows[0], 1);

        $errors = [];
        foreach ($dataRows as $index => $row) {
            $rowData = array_combine($expectedHeader, $row);

            $validator = Validator::make($rowData, [
                'category_id'   => 'required|exists:categories,id',
                'name'          => 'required|string',
                'description'   => 'required|string',
                'price'         => 'required|numeric',
                'harga_satuan'  => 'required|numeric',
                'jumlah_obat'   => 'required|integer|min:0',
                'expired_obat'  => 'required|date',
                'image_url'     => 'nullable|url',
            ]);

            if ($validator->fails()) {
                $errors[$index + 2] = $validator->errors()->all();
                continue;
            }

            $imageName = null;
            if (!empty($rowData['image_url'])) {
                try {
                    $imageContents = file_get_contents($rowData['image_url']);
                    $imageName = 'products/' . uniqid() . '.jpg';
                    Storage::put('public/' . $imageName, $imageContents);
                } catch (\Exception $e) {
                    $errors[$index + 2][] = 'Failed to download image from URL.';
                }
            }

            $product = Product::create([
                'category_id' => $rowData['category_id'],
                'name'        => $rowData['name'],
                'description' => $rowData['description'],
                'price'       => $rowData['price'],
                'harga_satuan'=> $rowData['harga_satuan'],
                'image'       => $imageName,
            ]);

            $product->stocks()->create([
                'jumlah_obat' => $rowData['jumlah_obat'],
                'expired_obat'=> $rowData['expired_obat'],
            ]);
        }

        if (!empty($errors)) {
            return redirect()->back()->withErrors(['excel_file' => 'Some rows failed to import.'])->with('import_errors', $errors);
        }

        return redirect()->route('products.index')->with('success', 'Products imported successfully.');
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
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'category'    => 'required|exists:categories,id',
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
                'name'        => $request->name,
                'description' => $request->description,
                'price'       => str_replace('.', '', $request->price),
                'harga_satuan'=> str_replace('.', '', $request->harga_satuan),
                'image'       => $image->hashName()
            ]);
        } else {
            $product->update([
                'category_id' => $request->category,
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
