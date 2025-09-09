<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssignHomePageController extends Controller
{
    public function index()
    {
        return view('assignHomePage');
    }
}
