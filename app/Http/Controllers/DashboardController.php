<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $SaleMonth= DB::select('select stock_id, orders, count(stock_id) as Ntimes FROM `detail_sales` group by stock_id, orders order by 2 desc');
        //$SaleMonth= DB::table('detail_sales')->get()->count('stock_id','stock');



       // return var_dump(json_encode( $SaleMonth));
        return Inertia::render('Dashboard/Show',['SaleMonth'=>$SaleMonth]);
    }
}
