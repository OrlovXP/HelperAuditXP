<?php

namespace App\Http\Controllers\Public\ReportCategory;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

class DestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($id)
    {
        // Поиск категории отчета по заданному идентификатору
        $reportCategory = ReportCategory::findOrFail($id);

        // Удаление категории отчета
        $reportCategory->delete();

        // Отправка ответа
        return redirect()->route('report-categories.index')
            ->with('success', 'Категория отчета успешно удалена.');
    }
}
