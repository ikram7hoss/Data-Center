<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Affiche le dashboard admin
    public function index()
    {
        return view('admin.dashboard');
    }
}
