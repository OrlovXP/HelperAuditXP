<?php

namespace App\Jobs;

use App\Services\Bitrix24Api;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetCompanyClientsB24Job implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $start;
    protected int $end;

    // Устанавливаем время ожидания в 3600 секунд
    public $timeout = 10800;

    public function __construct(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function handle(Bitrix24Api $bitrix24Api)
    {
        $bitrix24Api->getAllCompanyClients($this->start, $this->end);
    }
}
