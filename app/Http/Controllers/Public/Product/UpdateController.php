<?php

namespace App\Http\Controllers\Public\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Product $product)
    {

        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'crm_product_id' => ['required', 'integer'],
        ]);

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Продукт успешно обновлен!');
    }
}

