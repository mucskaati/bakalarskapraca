<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontend.homepage.index', []);
    }
}
