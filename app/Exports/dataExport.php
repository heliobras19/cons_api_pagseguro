<?php

namespace App\Exports;

use App\models\inscrito;
use Maatwebsite\Excel\Concerns\FromCollection;

class dataExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return inscrito::all();
    }
}