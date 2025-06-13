<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index()
    {
        return view('admin.peta.index');
    }

    public function marker()
    {
        return view('admin.peta.marker');
    }

    public function layer()
    {
        return view('admin.peta.layer');
    }

    public function layer_group()
    {
        return view('admin.peta.layer_group');
    }
}
