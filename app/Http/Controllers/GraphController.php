<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GraphController extends Controller
{
    public function graph1() {
        return view('graphs.graph1');
    }
}
