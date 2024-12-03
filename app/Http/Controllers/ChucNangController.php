<?php

namespace App\Http\Controllers;

use App\Models\ChucNang;
use Illuminate\Http\Request;

class ChucNangController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 42;
        
        $data = ChucNang::get();
        
        return response()->json([
            'data' => $data
        ]);
    }
}
