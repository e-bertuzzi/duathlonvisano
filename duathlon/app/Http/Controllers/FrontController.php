<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function getIndex() {
        return redirect()->route('race.index');
    }
}
