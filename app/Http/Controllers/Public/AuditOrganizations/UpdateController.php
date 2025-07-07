<?php

namespace App\Http\Controllers\Public\AuditOrganizations;

use App\Http\Controllers\Controller;
use App\Jobs\CreateItemRegistry;
use App\Models\Registry;
use App\Services\FocusApi;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $basic_inn, FocusApi $focusApi)
    {
        $focusApi->req($basic_inn);

        return Redirect::back()->with('success', 'Процесс обновления добавлен в очередь.');
    }
}
