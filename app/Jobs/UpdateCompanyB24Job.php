<?php

namespace App\Jobs;

use App\Models\Registry;
use App\Services\Bitrix24Api;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCompanyB24Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 10800;

    protected $inn;
    protected $fields;

    public function __construct($inn, array $fields)
    {
        $this->inn = $inn;
        $this->fields = $fields;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Bitrix24Api $bitrix24Api)
    {

        $companyData = $bitrix24Api->getCompanyId($this->inn);
        $companyId = $companyData['result'][0]['ID'] ?? null; // Extract company ID from response.

        // Ensure a company was found with the provided INN before attempting update.
        if ($companyId) {
            $bitrix24Api->updateCompanyB24($companyId, $this->fields);
        }
    }



}
