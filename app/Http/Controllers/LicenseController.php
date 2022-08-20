<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index()
    {
        return view('license');
    }
}
