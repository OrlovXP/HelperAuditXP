<?php

namespace App\Http\Controllers\Public\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class EditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Product $product)
    {

        return view('public.products.edit', compact('product'));

    }
}

