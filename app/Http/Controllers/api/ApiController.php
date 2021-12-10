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

    public function paginate($total)
    {
        $page = is_numeric(\request('page')) ? \request('page') : 1;
        $per_page = is_numeric(\request('per_page')) ? \request('per_page') : 5;

        $total_pages = ceil($total / $per_page);

        $pages = [];

        for ($i=1; $i <= $total_pages; $i++){
            array_push($pages, $i);
        }

        return [
            'pages'         => $pages,
            'per_page'      => $per_page,
            'current_page'  => (int) $page,
            'has_next'      => ($page < $total_pages) ? true : false,
            'has_prev'      => ($page > 1 ) ? true : false
        ];
    }
}
