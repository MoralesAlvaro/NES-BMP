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
        $Top3 = DB::select('SELECT stocks.name, SUM(detail_sales.orders) as totales FROM `detail_sales`
       INNER JOIN `stocks`  ON detail_sales.stock_id = stocks.id
       WHERE detail_sales.stock_id = detail_sales.stock_id GROUP BY stocks.name ORDER BY totales DESC LIMIT 3;');

        $year = date("Y");
        //venta del mes

        $SaleMonth = DB::table('detail_sales')
    ->selectRaw('SUM(total) as totales, MONTH(created_at) AS month')
    ->where(DB::raw('YEAR(created_at)'), '=', $year)
    ->groupBy('month')
    ->orderByRaw('CASE WHEN month < 4 THEN month + 12 ELSE month END')
    ->get();
            // dd($SaleMonth);

        $monthTranslations = [
            '1' => 'Enero',
            '2' => 'Febrero',
            '3' => 'Marzo',
            '4' => 'Abril',
            '5' => 'Mayo',
            '6' => 'Junio',
            '7' => 'Julio',
            '8' => 'Agosto',
            '9' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre',
        ];

        foreach ($SaleMonth as $item) {
            $item->month = $monthTranslations[$item->month] ?? $item->month;
        }

        $week = date('W');
        $year = date('Y');

        $SaleWeek = DB::table('detail_sales')
            ->select(DB::raw('DAYNAME(created_at) as day'), DB::raw('SUM(total) as totales'))
            ->where(DB::raw('WEEK(created_at, 1)'), '=', $week)
            ->where(DB::raw('YEAR(created_at)'), '=', $year)
            ->groupBy(DB::raw('DAYNAME(created_at)'))
            ->orderBy(DB::raw('DAYNAME(created_at)'))
            ->get();

        $result = [];

        $dayTranslations = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        $result = [];

        foreach ($SaleWeek as $sale) {
            $sale->day = $dayTranslations[$sale->day] ?? $sale->day;
            $result[] = (object) [
                'dia' => $sale->day,
                'totales' => $sale->totales,
            ];
        }

        usort($result, function ($a, $b) use ($dayTranslations) {
            $aIndex = array_search($a->dia, array_values($dayTranslations));
            $bIndex = array_search($b->dia, array_values($dayTranslations));
            return $aIndex - $bIndex;
        });


        return Inertia::render('Dashboard/Show', [
            'Top3' => $Top3,
            'SaleMonth' => $SaleMonth,
            'SaleWeek' => $result,
        ]);
    }

    public function acercaDe()
    {
        return Inertia::render('acercade/Show',);
    }
}
