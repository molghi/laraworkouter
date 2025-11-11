<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show_form () {
        return view('form');
    }

    // ==================================================
}
