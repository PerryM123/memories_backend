<?php

namespace App\Http\Controllers;

use App\Models\RankInfo;
use App\Models\RankingCategories;
use Exception;
use Illuminate\Http\Request;
// TODO: Logの共通helper関数を作ろうかな
use Illuminate\Support\Facades\Log;

class RankInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, string $rank_id)
    {
        Log::info('[LOG] THIS IS INDEX');
        // TODO: Instead of doing individual validation, should I use request validation?
        if (!is_numeric($rank_id)) {
            return response()->json(['error_info' => 'rank_id must be a number'], 400);
        }
        // TODO: maybe it's better to use a constant instead of using a string for the column names
        // TODO: maybe it's better to use get() instead of first()?
        $ranking_categories = RankingCategories::where('ranking_categories_id', $rank_id)->first();

        if (!$ranking_categories) {
            return response()->json(['error_info' => 'ranking category not found'], 404);
        }
        $rank_info = RankInfo::where('ranking_categories_id', $rank_id)
            ->select('rank_number', 'title', 'image_url')
            ->get();
        if (!$rank_info) {
            return response()->json(['error_info' => 'no rank info found'], 404);
        }
        // TODO: もっと適切なログ出力方法は募集中
        Log::info('rank_info data:', ['rank_info' => $rank_info]);
        $ranking_categories['rank_info'] = $rank_info;
        return response()->json($ranking_categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // QUESTION: Should logs like this never be in the code?
        Log::info('[LOG] THIS IS STORE');
        $validatedData = $request->validate([
            'rank_title' => 'required|string|max:255',
            'rank_info' => 'required|array',
            'rank_info.*.rank_number' => 'required|integer|min:1',
            'rank_info.*.title' => 'required|string|max:255',
            'rank_info.*.image_url' => 'required|url',
        ]);

        // TODO: Learn how to do request validation 
        // $book = RankInfo::create($validatedData);
        $body_test_perry = $request->body;


        Log::info('rank_info store data:', ['request' => $request]);
        Log::info('rank_info store data:', ['rank_info_hello' => $body_test_perry]);
        Log::info('rank_info store data:', ['validatedData' => $validatedData]);
        Log::info('rank_info store data:', ['validatedData' => $validatedData]);
        try {
            // TODO: 
            // $rankInfo = RankInfo::create($validatedData);
            $ranking_categories = RankingCategories::create(['rank_title' => $validatedData['rank_title']]);

            return response()->json($ranking_categories, 201);
        } catch (Exception $e) {
            Log::error('[LOG][ERROR] Database error: ' . $e->getMessage());
            return response()->json(['error_info' => 'unexpected error creating rank info'], 500);
        }
    }

    public function getAllCategories(Request $request)
    {
        Log::info('[LOG] THIS IS getAllCategories');
        $ranking_categories = RankingCategories::all();
        return response()->json($ranking_categories);
    }

    public function getAllRankInfo(Request $request)
    {
        Log::info('[LOG] THIS IS getAllRankInfo');
        $rank_info = RankInfo::all();
        return response()->json($rank_info);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
