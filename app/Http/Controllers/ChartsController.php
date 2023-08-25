<?php

namespace App\Http\Controllers;

use App\Models\Order;

class ChartsController extends Controller
{
    public function index()
    {
        $thisYearOrders = Order::query()
            ->whereYear('created_at', date('Y'))
            ->groupByMonth();

        $lastYearOrders = Order::query()
            ->whereYear('created_at', date('Y') - 1)
            ->groupByMonth();


        return view('charts', [
            'thisYearOrders' => $thisYearOrders,
            'lastYearOrders' => $lastYearOrders,
        ]);
    }
}
