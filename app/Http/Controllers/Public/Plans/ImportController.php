<?php

namespace App\Http\Controllers\Public\Plans;

use App\Http\Controllers\Controller;
use App\Imports\PlansImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * Handle the incoming request.
     */
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

        Excel::import(new PlansImport, $file);



        return redirect('/')->with('success', 'All good!');



    }
}
