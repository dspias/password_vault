<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsvController extends Controller
{
    /**
     * Download vault in csv file
     */
    public function export()
    {
        return response()->json($this->folders());
    }

    /**
     * Import vault from csv file
     */
    public function import(Request $request)
    {
        return response()->json($this->folders());
    }

}
