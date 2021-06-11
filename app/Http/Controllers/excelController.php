<?php

namespace App\Http\Controllers;

use App\Exports\dataExport;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

class excelController extends Controller
{
    public function export()
    {
        return Excel::download(new dataExport, 'inscritos.xlsx');
    }
}