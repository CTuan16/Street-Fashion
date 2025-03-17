<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sizeSelectionController extends Controller
{
    //
    public function sizeSelection()
    {
        return view('client.selection');
    }
}
