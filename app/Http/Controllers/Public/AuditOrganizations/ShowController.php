<?php

namespace App\Http\Controllers\Public\AuditOrganizations;

use App\Http\Controllers\Controller;
use App\Models\Registry;
use App\Services\Bitrix24Api;
use App\Services\FocusApi;
use Illuminate\Http\Request;



class ShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Registry $basic_inn, Bitrix24Api $bitrix24Api, FocusApi $focusApi)
    {
        //dd($basic_inn->basic_inn);
        setlocale(LC_TIME, 'ru_RU.UTF-8');

        // Тут проверить если focus_is_synchronized = 0 то синхронизировать
        //dump($focusApi->req($basic_inn->basic_inn));

        $stats = $focusApi->getStat();


        $companies = $bitrix24Api->getCompany($basic_inn->basic_inn);

        if (count($companies) === 1) {
            $companies = $companies[0];
        }


        //dd($companies);

        if (!empty($companies)) {
            $filter = [
                '=COMPANY_ID' => $companies['ID'],
            ];
            $select = [
                'ID', 'OPPORTUNITY', 'STAGE_ID', 'CLOSEDATE', 'UF_CRM_1449516944', 'UF_CRM_1486372471'
            ];
            $order = ['CLOSEDATE' => 'DESC'];

            // AuditXP
            $wonDealsAuditXP = $bitrix24Api->getDealsWithFilter([
                ...$filter, '=CATEGORY_ID' => '4', '=STAGE_ID' => 'C4:WON'
            ], $select, $order);
            $loseDealsAuditXP = $bitrix24Api->getDealsWithFilter([
                ...$filter, '=CATEGORY_ID' => '4', '=STAGE_ID' => [
                    'C4:LOSE', 'C4:1', 'C4:11', 'C4:2', 'C4:13', 'C4:4', 'C4:5', 'C4:3', 'C4:6', 'C4:7', 'C4:10',
                    'C4:14',
                    'C4:15', 'C4:17'
                ]
            ], $select);

            // Kontur
            $wonDealsKontur = $bitrix24Api->getDealsWithFilter([
                ...$filter, '=CATEGORY_ID' => '13', '=STAGE_ID' => 'C13:WON'
            ], $select, $order);
            $loseDealsKontur = $bitrix24Api->getDealsWithFilter([
                ...$filter, '=CATEGORY_ID' => '13', '=STAGE_ID' => [
                    'C13:LOSE', 'C13:1', 'C13:2', 'C13:3', 'C13:4', 'C13:5', 'C13:6', 'C13:7', 'C13:8', 'C13:9',
                    'C13:10', 'C13:11', 'C13:16', 'C13:14', 'C13:15', 'C13:19'
                ]
            ], $select);

            $wonTotalOpportunity = array_reduce($wonDealsAuditXP, function ($carry, $deal) {
                return $carry + $deal['OPPORTUNITY'];
            }, 0);

            $loseTotalOpportunity = array_reduce($loseDealsAuditXP, function ($carry, $deal) {
                return $carry + $deal['OPPORTUNITY'];
            }, 0);

            $wonTotalOpportunityKontur = array_reduce($wonDealsKontur, function ($carry, $deal) {
                return $carry + $deal['OPPORTUNITY'];
            }, 0);

            $loseTotalOpportunityKontur = array_reduce($loseDealsKontur, function ($carry, $deal) {
                return $carry + $deal['OPPORTUNITY'];
            }, 0);

            $loseDeal = !empty($loseDealsAuditXP) ? [
                'COUNT' => count($loseDealsAuditXP),
                'TOTAL_OPPORTUNITY' => number_format($loseTotalOpportunity, 2, '.', ' '),
            ] : null;

            $firstDial = reset($wonDealsAuditXP);

            $lastWonDeal = $firstDial !== false ? [
                'ID' => $firstDial['ID'],
                'DATE' => strftime('%d %B %Y', strtotime($firstDial['CLOSEDATE'])),
                'PRODUCT' => $bitrix24Api->getValue(210, $firstDial['UF_CRM_1449516944'][0]),
                'OPPORTUNITY' => number_format($firstDial['OPPORTUNITY'], 2, '.', ' '),
                'SOURCE' => $bitrix24Api->getValue(278, $firstDial['UF_CRM_1486372471'][0]),
            ] : null;

            $companies['DEALS_AUDITXP'] = [
                'WON' => [
                    'COUNT' => count($wonDealsAuditXP),
                    'TOTAL_OPPORTUNITY' => number_format($wonTotalOpportunity, 2, '.', ' '),
                ],
                'LOSE' => $loseDeal,
                'LAST_WON' => $lastWonDeal
            ];

            $loseDeal = !empty($loseDealsKontur) ? [
                'COUNT' => count($loseDealsKontur),
                'TOTAL_OPPORTUNITY' => number_format($loseTotalOpportunityKontur, 2, '.', ' '),
            ] : null;

            $firstDial = reset($wonDealsKontur);

            $lastWonDeal = $firstDial !== false ? [
                'ID' => $firstDial['ID'],
                'DATE' => strftime('%d %B %Y', strtotime($firstDial['CLOSEDATE'])),
                'PRODUCT' => $bitrix24Api->getValue(210, $firstDial['UF_CRM_1449516944'][0]),
                'OPPORTUNITY' => number_format($firstDial['OPPORTUNITY'], 2, '.', ' '),
                'SOURCE' => $bitrix24Api->getValue(278, $firstDial['UF_CRM_1486372471'][0]),
            ] : null;

            $companies['DEALS_KONTUR'] = [
                'WON' => [
                    'COUNT' => count($wonDealsKontur),
                    'TOTAL_OPPORTUNITY' => number_format($wonTotalOpportunityKontur, 2, '.', ' '),
                ],
                'LOSE' => $loseDeal,
                'LAST_WON' => $lastWonDeal

            ];
        } else {
            $companies = null;
        }

        return view('public.audit-organizations.show', ['register' => $basic_inn, 'companies' => $companies, 'stats' => $stats]);
    }
}
