<?php

namespace App\Http\Controllers\Public\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
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
            'id_billing' => ['required'],
            'id_crm' => ['required'],
        ]);

        Manager::create($validatedData);

        return redirect()->route('managers.index')->with('success', 'Менеджер успешно создан!');
    }
}

