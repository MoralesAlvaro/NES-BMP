<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    public function index()
    {
        // Productos más vendidos.
        $Top3 = DB::select('SELECT stocks.name, SUM(detail_sales.orders) as totales FROM `detail_sales`
        INNER JOIN `stocks`  ON detail_sales.stock_id = stocks.id
        WHERE detail_sales.stock_id = detail_sales.stock_id GROUP BY stocks.name ORDER BY totales DESC LIMIT 3;');

        // Venta del mes.
        $SaleMonth = DB::table('detail_sales')
        ->selectRaw('SUM(total) as totales, DATE_FORMAT(created_at, "%M") AS month')
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $week = date("W");

        // Venta de la semana.
        $SaleWeek = DB::table('detail_sales')
        ->select(DB::raw("SUM(total) as totales"), DB::raw("DATE_FORMAT(created_at, '%V') as week"))
        ->where(DB::raw("DATE_FORMAT(created_at, '%V')"), '=', $week)
        ->groupBy(DB::raw("DATE_FORMAT(created_at, '%V')"))
        ->get();

        //return var_dump(json_encode( $SaleWeek));

        //return var_dump(json_encode( $Top3));
        return Inertia::render('Dashboard/Show',[
            'Top3'=>$Top3,
            'SaleMonth'=>$SaleMonth,
            'SaleWeek'=>$SaleWeek
        ]);
    }
}
