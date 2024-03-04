<?php

namespace App\Http\Controllers\Public\Excel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function __invoke(Request $request)
    {
        // Проверяем, был ли загружен файл
        if (!$request->hasFile('file')) {
            // Если файл не был загружен, возвращаем обратно с сообщением об ошибке
            return redirect()->back()->with('error', 'Файл не был выбран.');
        }

        $file = $request->file('file');

        // Проверяем, является ли загруженный файл допустимым файлом Excel
        if (!$file->isValid() || !in_array($file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            // Если файл не является допустимым файлом Excel, возвращаем обратно с сообщением об ошибке
            return redirect()->back()->with('error', 'Недопустимый файл. Пожалуйста, выберите файл в формате Excel (XLSX, XLS).');
        }

        // Импортируем данные из файла Excel
        Excel::import(new \App\Imports\ReportsImport, $file);

        // Перенаправляем обратно с успешным сообщением
        return redirect()->back();
    }
}
