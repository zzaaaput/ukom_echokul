<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;

class TemplateController extends Controller
{
    public function siswa()
    {
        $ekstrakurikulers = Ekstrakurikuler::with('pembina')->get();
        $pembinas = Ekstrakurikuler::whereHas('pembina', function($q){
            $q->where('role', 'pembina');
        })->with('pembina')->get();

        return view('siswa.index', compact('ekstrakurikulers', 'pembinas'));
    } 
}