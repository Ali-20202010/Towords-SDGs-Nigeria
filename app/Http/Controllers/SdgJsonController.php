<?php

namespace App\Http\Controllers;

use App\Services\SdgJsonService;
use Illuminate\Http\Request;

class SdgJsonController extends Controller
{
    public function goals(SdgJsonService $svc)
    {
        $index = $svc->listGoals();
        return response()->json($index);
    }

    public function goal($goal, Request $req, SdgJsonService $svc)
    {
        $goal = (int) $goal;
        $rows = $svc->filter($goal, [
            'state'    => $req->query('state'),
            'code'     => $req->query('code'),
            'year_min' => $req->query('year_min'),
            'year_max' => $req->query('year_max'),
        ]);

        $page = max(1, (int) $req->query('page', 1));
        $per  = max(1, min(2000, (int) $req->query('per', 100)));
        $total = count($rows);
        $slice = array_slice($rows, ($page-1)*$per, $per);

        return response()->json([
            'goal'  => $goal,
            'total' => $total,
            'page'  => $page,
            'per'   => $per,
            'data'  => $slice,
        ]);
    }
}
