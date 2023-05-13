<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailSale;
use App\Models\Sale;
use Inertia\Inertia;
use App\Http\Resources\SaleCollection;
use Illuminate\Support\Facades\Auth;

class DailySaleController extends Controller
{
    public function index()
    {
        $sales = new SaleCollection(Sale::all());
        return response()->json($sales, 200);
    }
}
