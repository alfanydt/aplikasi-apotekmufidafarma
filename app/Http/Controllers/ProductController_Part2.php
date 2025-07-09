<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
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
}
