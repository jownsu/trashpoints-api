<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    protected function isOwnedByUser($action, $model)
    {
        if(auth()->user()->can($action, $model)){
            return true;
        }
    }

    public function pivotTotal($table, $alias, $unit = 'points')
    {
        $total = DB::table($table)
            ->select(DB::raw("SUM(" . $table . ".quantity * " . $table . "." .  $unit .") as " . $alias . ",  COUNT(id) as total_count"))
            ->first();

        return $total;
    }


}
