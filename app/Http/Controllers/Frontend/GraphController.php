<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function graph1()
    {
        return view('frontend.graphs.graph1');
    }
}
