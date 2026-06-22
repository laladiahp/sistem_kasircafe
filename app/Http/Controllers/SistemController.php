<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SistemController extends Controller
{
    public function index()
    {
        return view ('dashboard.master');
    }

    public function home()
    {
        return view('home.index');
    }

    public function form()
    {
        return view('form.index');
    }
}
