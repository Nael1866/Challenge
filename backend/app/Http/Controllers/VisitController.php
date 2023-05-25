<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function recordVisit(Request $request, $news_id)
    {
        $visit = new Visit;
        $visit->news_id = $news_id;
        $visit->user_id = auth()->user()->id;
        $visit->visited_at = now();

        $visit->save();

        return response()->json([
            'message' => 'Visit recorded successfully'
        ], 201);
    }
        
    public function getAggregates(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // get total clicks per news category
        $total_visits = Visit::select('news_id', DB::raw('count(*) as total'))
            ->whereBetween('visited_at', [$start_date, $end_date])
            ->groupBy('news_id')
            ->get();

        // get unique clicks per news category
        $unique_visits = Visit::select('news_id', DB::raw('count(DISTINCT user_id) as unique_visits'))
            ->whereBetween('visited_at', [$start_date, $end_date])
            ->groupBy('news_id')
            ->get();

        return response()->json([
            'total_visits' => $total_visits,
            'unique_visits' => $unique_visits,
        ], 200);
    }
    }
