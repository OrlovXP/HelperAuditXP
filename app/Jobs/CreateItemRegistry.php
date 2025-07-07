<?php

namespace App\Jobs;

use App\Models\Auditor;
use App\Models\Bitrix24CompanyType;
use App\Models\Inspection;
use App\Models\Registry;
use App\Models\Status;
use App\Services\Bitrix24Api;
use Carbon\Carbon;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateItemRegistry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $ornz;

    /**
     * Create a new job instance.
     */
    public function __construct($ornz)
    {
        $this->ornz = $ornz;
    }

    /**
     * Execute the job.
     */
    public function handle(Bitrix24Api $bitrix24Api): void
    {
        // {$this->ornz}

        $client = new Client();

        $crawler = $client->request('GET', "https://sroaas.ru/firms/{$this->ornz}/?tab=tab1");

        $data = []; // Создаем пустой массив для данных

        $blockStatus = $crawler->filter('.b-status-label')->eq(0);

        $block0 = $crawler->filter('.b-collapse-block')->eq(0);

        $block1 = $crawler->filter('.b-collapse-block')->eq(1);

        $block2_1 = $crawler->filter('.b-collapse-block')->eq(2);

        $block2_2 = $crawler->filter('.b-collapse-block .b-collapse-block__body')->eq(2);

        $block3 = $crawler->filter('.b-collapse-block')->eq(3);

        $block5 = $crawler->filter('.b-collapse-block .b-collapse-block__body')->eq(5);

        $block13 = $crawler->filter('.b-collapse-block')->eq(13);

        $block17 = $crawler->filter('.b-collapse-block')->eq(17);

        $block18 = $crawler->filter('.b-collapse-block')->eq(18);

        $block19 = $crawler->filter('.b-collapse-block')->eq(19);


        $block0->filter('div.text-muted.small')->each(function ($node) use (&$data) {
            if ($node->text() == "Краткое наименование") {
                $data['name'] = $node->nextAll()->text();
            }
            if ($node->text() == "ОРНЗ") {
                $data['ornz'] = $node->nextAll()->text();
            }
            if ($node->text() == "ОГРН") {
                $data['ogrn'] = $node->nextAll()->text();
            }
            if ($node->text() == "Субъект РФ") {
                $data['subject'] = $node->nextAll()->text();
            }
            if ($node->text() == "ИНН") {
                $data['basic_inn'] = $node->nextAll()->text();
            }
            if ($node->text() == "Дата внесения записи в реестр") {
                $originalDate = $node->nextAll()->text();
                $data['basic_date_entry_into_register'] = Carbon::createFromFormat('d.m.Y', $originalDate)->format('Y-m-d');
            }
            if ($node->text() == "Дата государственной регистрации юридического лица") {
                $data['basic_date_state_registration_entity'] = $node->nextAll()->text();
            }
        });

        $block3->filter('div.text-muted.small')->each(function ($node) use (&$data) {
            if ($node->text() == "Вид нарушения") {
                $text = $node->nextAll()->text();
                $data['disciplinary_type_violation'] = $text == 'Нет данных' ? null : $text;
            }
            if ($node->text() == "Меры дисциплинарного воздействия") {
                $text = $node->nextAll()->text();
                $data['disciplinary_disciplinary_measures'] = $text == 'Нет данных' ? null : $text;
            }
            if ($node->text() == "Орган, принявший решение") {
                $text = $node->nextAll()->text();
                $data['disciplinary_body_that_made_decision'] = $text == 'Нет данных' ? null : $text;
            }
            if ($node->text() == "Срок приостановления членства (дни)") {
                $text = $node->nextAll()->text();
                $data['disciplinary_membership_suspension_period'] = $text == 'Нет данных' ? null : $text;
            }
            if ($node->text() == "Дата, с которой восстановлено членство") {
                $text = $node->nextAll()->text();
                $data['disciplinary_date_which_membership_was_reinstated'] = $text == 'Нет данных' ? null : $text;
            }
            if ($node->text() == "Дата погашения меры") {
                $text = $node->nextAll()->text();
                $data['disciplinary_maturity_date_measure'] = $text == 'Нет данных' ? null : $text;
            }
        });

        $block13->filter('div.text-muted.small')->each(function ($node) use (&$data) {
            if ($node->text() == "Должность/Наименование") {
                $data['controls_job_title'] = $node->nextAll()->text();
            }
            if ($node->text() == "Фамилия") {
                $data['controls_surname'] = $node->nextAll()->text();
            }
            if ($node->text() == "Имя") {
                $data['controls_name'] = $node->nextAll()->text();
            }
            if ($node->text() == "Отчество") {
                $data['controls_family'] = $node->nextAll()->text();
            }
            if ($node->text() == "ОРНЗ") {
                $data['controls_ornz'] = $node->nextAll()->text();
            }
        });

        $block1->filter('div.text-muted.small')->each(function ($node) use (&$data, &$phoneData) {
            if ($node->text() == "Адрес электронной почты") {
                $data['contacts_email'] = $node->nextAll()->text();
            }

            if ($node->text() == "Адрес постоянно действующего исполнительного органа") {
                $data['contacts_address_executive_body'] = $node->nextAll()->text();
            }

            if ($node->text() == "Телефон") {
                $phonesString = $node->nextAll()->text();
                $phonesArray = preg_split('/[,;]\s*/', $phonesString);
                foreach ($phonesArray as $phone) {
                    $phone = ltrim($phone);
                    if (!empty($phone)) {
                        $phoneData[] = ['phone_number' => $phone];
                    }
                }
            }

            if ($node->text() == "Адрес официального сайта в сети Интернет") {
                $data['contacts_site'] = $node->nextAll()->text();
            }
        });

        $block2_1->filter('div.text-muted.small')->each(function ($node) use (&$data) {
            if ($node->text() == "Количество аудиторов - сотрудников аудиторской организации") {
                $data['employees_count'] = $node->nextAll()->text();
            }
        });

        if (empty($bitrix24Api->getCompany($data['basic_inn']))) {
            $fields = [
                'TITLE' => $data['ornz'].' '.$data['name'],
                'ASSIGNED_BY_ID' => 2897,
                'UF_CRM_1441615404' => $data['basic_inn'],
                'UF_CRM_1675089975' => $data['basic_inn'],
                'COMPANY_TYPE' => 15,
                'UF_CRM_1449494297' => [1067],
                'UF_CRM_1521312495' => $data['ornz'],
            ];

            $bitrix24Api->addCompany($fields);
        }


        $company = $bitrix24Api->getCompany($data['basic_inn']);
        if (count($company) === 1) {
            $company = $company[0];
        }

        $statusName = null;

        if (isset($company['COMPANY_TYPE'])) {
            $statusName = $bitrix24Api->getCompanyNameByStatusId($company['COMPANY_TYPE']);
        }

        if ($statusName) {
            $bitrix24Type = Bitrix24CompanyType::firstOrCreate(['type' => $statusName]);
            $data['bitrix24_company_type_id'] = $bitrix24Type->id;
        }


//        $data['company_aac'] = true;
//        $data['aac_is_active'] = true;
//        $data['aac_is_suspended'] = false;
//        $data['aac_is_excluded'] = false;
//        $data['aac_is_not_registry'] = false;

        if ($blockStatus->count() > 0) {
            $statusText = $blockStatus->eq(0)->text(); // получаем текст элемента

            if ($statusText === 'Приостановлено членство') {
                $data['aac_is_suspended'] = true;
                $data['aac_is_active'] = false;
            }

            if ($statusText === 'Исключена') {
                $data['aac_is_excluded'] = true;
                $data['aac_is_active'] = false;
            }
        }else{
            $data['aac_is_active'] = true;
            $data['aac_is_suspended'] = false;
            $data['aac_is_excluded'] = false;
        }


        $data['aac_is_not_registry'] = false; // не зарегистрирована


        $ozo1 = '';
        $ozo2 = '';

        $block18->filter('div.text-muted.small')->each(function ($node) use (&$ozo1, &$ozo2) {
            if ($node->text() == "Дата внесения") {
                $ozo1 = $node->nextAll()->text();
            }
            if ($node->text() == "Дата исключения") {
                $ozo2 = $node->nextAll()->text();
            }
        });

        if (!str_contains($ozo1, 'Нет данных')) {
            $data['ozo_is_status'] = true;
        }

        if (!str_contains($ozo2, 'Нет данных')) {
            $data['ozo_is_status'] = false;
        }


        $ozofr1 = '';
        $ozofr2 = '';

        $block19->filter('div.text-muted.small')->each(function ($node) use (&$ozofr1, &$ozofr2) {
            if ($node->text() == "Дата внесения") {
                $ozofr1 = $node->nextAll()->text();
            }
            if ($node->text() == "Дата исключения") {
                $ozofr2 = $node->nextAll()->text();
            }
        });

        if (!str_contains($ozofr1, 'Нет данных')) {
            $data['ozofr_is_status'] = true;
        }

        if (!str_contains($ozofr2, 'Нет данных')) {
            $data['ozofr_is_status'] = false;
        }


        //$registry = Registry::create($data);

        $registry = Registry::firstOrNew(['basic_inn' => $data['basic_inn']]);

        $registry->fill($data);

        $registry->save();

        $block5->filter('div.row')->each(function ($row) use ($registry) {
            $divs = $row->filter('.col-12.col-lg-4');
            $count = $divs->count();


            if ($count >= 2) {
                $datesOfInspection = $divs->eq(0)->filter('p')->text();
                $inspectingOrgan = $divs->eq(1)->filter('p')->text();

                $inspectionData = [
                    'dates_of_inspection' => trim($datesOfInspection),
                    'inspecting_organ' => trim($inspectingOrgan),
                ];

                $registry->inspections()->updateOrCreate($inspectionData);
            }
        });

        $block2_2->filter('div.row')->each(function ($row) use ($registry) {
            $divs = $row->filter('.col-12.col-lg-4');
            $count = $divs->count();

            if ($count >= 2) {
                $auditorFio = $divs->eq(0)->filter('p')->text();
                $auditorOrnz = $divs->eq(1)->filter('p')->text();

                $auditorData = [
                    'auditor_fio' => trim($auditorFio),
                    'auditor_ornz' => trim($auditorOrnz),
                ];
                $registry->auditors()->updateOrCreate($auditorData);
            }
        });

        $block17->filter('div.row')->each(function ($row) use ($registry) {
            $divs = $row->filter('.col-12.col-lg-4');
            $count = $divs->count();

            if ($count >= 2) {
                $reportTitle = $divs->eq(0)->filter('p')->text();
                $numberConclusions = $divs->eq(1)->filter('p')->text();

                $auditorData = [
                    'report_title' => trim($reportTitle),
                    'number_conclusions' => trim($numberConclusions),
                ];
                $registry->auditActivity()->updateOrCreate($auditorData);
            }
        });

        foreach ($phoneData as $phone) {
            $registry->phones()->updateOrCreate(['phone_number' => $phone['phone_number']], $phone);
        }
    }
}
