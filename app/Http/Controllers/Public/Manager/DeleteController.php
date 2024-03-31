<?php

namespace App\Http\Controllers\Public\Manager;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Manager $manager)
    {

        $manager->delete();
        return redirect()->route('managers.index')->with('success', 'Менеджер успешно удален!');

    }
}

