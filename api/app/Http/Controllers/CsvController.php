<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CsvController extends Controller
{
    /**
     * Download vault in csv file
     */
    public function export()
    {
        return Excel::download(new ExportItems, 'vault.csv');
    }

    /**
     * Import vault from csv file
     */
    public function import(Request $request)
    {
        return response()->json($this->folders());
    }

}
