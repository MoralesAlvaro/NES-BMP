<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailSale;
use App\Models\Sale;
use Inertia\Inertia;
use App\Http\Resources\SaleCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ( ! Auth::user()->can('dailySale_list')){//cambiar luego el permiso
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        if ($request->date) {
            $fecha = $request->date;
        }else{
            $fecha = date("Y-m-d");
        }

        $sales = new SaleCollection(Sale::all());
        $sales = DB::select("
            SELECT s.name AS 'producto', t.name AS 'tipo', SUM(d.orders) AS 'cantidad', s.cost,
            (SUM(d.orders) * s.cost) AS 'total',
            (SELECT SUM(d2.orders * s2.cost)
            FROM detail_sales d2
            INNER JOIN stocks s2 ON s2.id = d2.stock_id
            WHERE DATE(d2.created_at) = ?) AS 'suma_total'
        FROM detail_sales d
        INNER JOIN stocks s ON s.id = d.stock_id
        INNER JOIN raw_materials r ON s.raw_material_id = r.id
        INNER JOIN type_products t ON d.type_product_id = t.id
        WHERE DATE(d.created_at) = ?
        GROUP BY s.name, s.cost, t.name;
        ", [$fecha, $fecha]);
        $permissions = Auth::user()->getAllPermissions();

        return Inertia::render('DailySale/Show', [
            'sales' => $sales,
            'permissions' => $permissions
        ]);

    }

    public function saleLog(Request $request)
    {
        if ( ! Auth::user()->can('sale_log')){//cambiar luego el permiso
            return redirect()->back()->withErrors(['warning' => 'No posees los permisos necesarios. Ponte en contacto con tu manager.']);
        }

        $sales = DB::select('SELECT SUM(s.total) AS total_suma, DATE(s.created_at) AS fecha
        FROM sales s
        WHERE YEAR(s.created_at) = YEAR(NOW())
        GROUP BY DATE(s.created_at);');

        $permissions = Auth::user()->getAllPermissions();
        return Inertia::render('SaleLog/Show', [
            'permissions' => $permissions,
            'sales' => $sales
        ]);
    }
}
