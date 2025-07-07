<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\Bitrix24Api;
use App\Services\KonturApi;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class TestBillyController extends Controller
{
    protected $konturApi;

    public function __construct(KonturApi $konturApi)
    {
        $this->konturApi = $konturApi;
    }



    public function testMethod()
    {
        $timestamp = $this->konturApi->getTimestamp();

        $news = $this->konturApi->getNews($timestamp);
        dump($news);
    }


}
