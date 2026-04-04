<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index($path = null)
    {
        return view('dashboard.index', [
            'path' => $path ?? ''
        ]);
    }
}