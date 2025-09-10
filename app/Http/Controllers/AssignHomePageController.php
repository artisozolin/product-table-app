<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AssignHomePageController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->get();

        return view('assignHomePage', compact('products'));
    }
}
