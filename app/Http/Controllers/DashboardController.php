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
        $SaleMonth= DB::select('SELECT stocks.name, SUM(detail_sales.orders) as totales FROM `detail_sales`
        INNER JOIN `stocks`  ON detail_sales.stock_id = stocks.id
        WHERE detail_sales.stock_id = detail_sales.stock_id GROUP BY stocks.name ORDER BY totales DESC LIMIT 3;');
        //$SaleMonth= DB::table('detail_sales')->get()->count('stock_id','stock');



       // return var_dump(json_encode( $SaleMonth));
        return Inertia::render('Dashboard/Show',['SaleMonth'=>$SaleMonth]);
    }
}
