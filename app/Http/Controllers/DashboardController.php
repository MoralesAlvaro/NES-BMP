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

        $year = date("Y");
        //venta del mes

        $SaleMonth = DB::table('detail_sales')
            ->selectRaw('SUM(total) as totales, MONTHNAME(created_at) AS month')
            ->where(DB::raw('YEAR(created_at)'), '=', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        // el foreach hace un recorrido por $SaleMonth a travez de $item y cambia el dato a la propiedad
        foreach ($SaleMonth as $item) {

            switch ($item->month) {
                case 'Jan':
                    $item->month = 'Enero';
                    break;
                case 'Feb':
                    $item->month = 'Febrero';
                    break;
                case 'Mar':
                    $item->month = 'Marzo';
                    break;
                case 'April':
                    $item->month = 'Abril';
                    break;
                case 'May':
                    $item->month = 'Mayo';
                    break;
                case 'Jun':
                    $item->month = 'Junio';
                    break;
                case 'Jul':
                    $item->month = 'Julio';
                    break;
                case 'Ago':
                    $item->month = 'Agosto';
                    break;
                case 'sep':
                    $item->month = 'Septiembre';
                    break;
                case 'Oct':
                    $item->month = 'Octubre';
                    break;
                case 'Nov':
                    $item->month = 'Noviembre';
                    break;
                case 'Dic':
                    $item->month = 'Diciembre';
                    break;

                default:
                    # code...
                    break;
            }
        }


        $week = date("W");

        // Venta de la semana.
        $SaleWeek = DB::table('detail_sales')
            ->select(DB::raw("SUM(total) as totales"), DB::raw("DATE_FORMAT(created_at, '%V') as week"))
            ->where(DB::raw("DATE_FORMAT(created_at, '%V')"), '=', $week)->where(DB::raw("DATE_FORMAT(created_at, '%X')", '=', $year), '=', $year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%V')"))
            ->get();

        //return var_dump(json_encode( $SaleWeek));
        //return var_dump(json_encode( $SaleMonth));
        //return var_dump(json_encode( $Top3));
        return Inertia::render('Dashboard/Show', ['Top3' => $Top3, 'SaleMonth' => $SaleMonth, 'SaleWeek' => $SaleWeek]);
    }
}
