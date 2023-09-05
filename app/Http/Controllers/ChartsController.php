<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ChartsController extends Controller
{
    public function index()
    {



        return view('charts');
    }
}
