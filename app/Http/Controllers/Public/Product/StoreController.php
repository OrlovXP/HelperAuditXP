<?php

namespace App\Http\Controllers\Public\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $validatedData = $request->validate([
            'name' => ['required'],
            'crm_product_id' => ['required'],
        ]);

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Продукт успешно создан!');
    }
}

