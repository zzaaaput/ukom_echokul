<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ekstrakurikuler;

class TemplateController extends Controller
{
       public function index()
    {
        $pembina = Ekstrakurikuler::with('pembina')
            ->whereHas('pembina', function ($q) {
                $q->where('role', 'pembina');
            })
            ->get();

        return view('siswa.index', compact('pembina'));
    }
}