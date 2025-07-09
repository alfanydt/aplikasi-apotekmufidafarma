<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        // jumlah data yang ditampilkan per paginasi halaman
        $pagination = 10;

        if ($request->search) {
            // menampilkan pencarian data
            $categories = Category::select('id', 'name')
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->paginate($pagination)
                ->withQueryString();
        } else {
            // menampilkan semua data
            $categories = Category::select('id', 'name')
                ->latest()
                ->paginate($pagination);
        }

        // tampilkan data ke view
        return view('categories.index', compact('categories'))->with('i', ($request->input('page', 1) - 1) * $pagination);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        // tampilkan form add data
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        // create data
        Category::create([
            'name' => $request->name
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('categories.index')->with(['success' => 'The new category has been saved.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // tampilkan form edit data
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        // get data by ID
        $category = Category::findOrFail($id);

        // update data
        $category->update([
            'name' => $request->name
        ]);

        // redirect ke halaman index dan tampilkan pesan berhasil ubah data
        return redirect()->route('categories.index')->with(['success' => 'The category has been updated.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        // get data by ID
        $category = Category::findOrFail($id);

        // delete data
        $category->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('categories.index')->with(['success' => 'The category has been deleted!']);
    }
}