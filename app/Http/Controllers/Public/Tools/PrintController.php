<?php

namespace App\Http\Controllers\Public\Tools;

use App\Http\Controllers\Controller;
use App\Services\KonturApi;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    protected $konturApi;

    public function __construct(KonturApi $konturApi) {
        $this->konturApi = $konturApi;
    }

    public function __invoke(Request $request){
        $id = $request->input('id');
        $data = $this->konturApi->printDeal($id);

        return view('public.tools.print', ['data' => $data]);
    }

}
