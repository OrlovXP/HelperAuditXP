<?php

namespace App\Http\Controllers\Public\AuditOrganizations;

use App\Http\Controllers\Controller;
use App\Jobs\GetCompanyClientsB24Job;
use App\Jobs\ParseListRegistryJob;
use App\Jobs\UpdateCompanyB24Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Redirect;

class ParserController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {


        Bus::chain([
//            new GetCompanyClientsB24Job(1, 5000),
            new ParseListRegistryJob(),
//            new UpdateCompanyB24Job(),
        ])->dispatch();

        return Redirect::back()->with('success', 'Процесс парсинга добавлен в очередь.');
    }
}
