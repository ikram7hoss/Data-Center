<?php

namespace App\Http\Controllers\Internal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ressource;

class ResourceController extends Controller
{
public function index(Request $request)
{
    $q = Ressource::query();

    if ($request->filled('type')) {
        $q->where('type', $request->type);
    }

    if ($request->filled('status')) {
        $q->where('status', $request->status);
    }

    $ressources = $q->orderBy('id', 'desc')->get();

    return view('internal.resources.index', compact('ressources'));
}
}

