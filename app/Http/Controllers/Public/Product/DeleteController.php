<?php

namespace App\Http\Controllers\Public\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product)
    {

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Продукт успешно удален!');

    }
}

