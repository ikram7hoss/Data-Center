<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataCenter;

class DataCenterController extends Controller
{
    public function index()
    {
        $datacenters = DataCenter::all();
        return view('datacenter.index', compact('datacenters'));
    }
}
