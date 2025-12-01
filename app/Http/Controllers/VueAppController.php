<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VueAppController extends Controller
{
    public function index()
    {
        return view('vue-app');
    }
}
