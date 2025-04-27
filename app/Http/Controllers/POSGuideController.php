<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POSGuideController extends Controller
{
    public function index()
    {
        return view('pos-guide');
    }
}