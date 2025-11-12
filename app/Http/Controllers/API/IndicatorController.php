<?php

namespace App\Http\Controllers\API;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndicatorController extends Controller
{
    public function GetIndicators(){
        $goals = \DB::table('goal_1')->select('StateName','Global_SDG_indicators')->distinct('Global_SDG_indicators')->orderBy('Global_SDG_indicators','ASC')->get();
        return response()->json($goals);
        // dd($goals);

    }
}
