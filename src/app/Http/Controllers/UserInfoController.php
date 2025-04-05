<?php

namespace App\Http\Controllers;

use App\Domain\UserInfo\Services\UserInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($userId, UserInfoService $UserInfoService)
    {
        $validator = Validator::make(['userId' => $userId], [
            'userId' => 'required|integer|min:1'
        ]);
        // QUESTION: There has to be a better way to do this... right??? I need to figure out the professional way of doing this...
        if ($validator->fails()) {
            return response()->json(['error_info' => 'validation error'], 400);
        }
        $user = $UserInfoService->getUserById($userId);
        if (!$user) {
            return response()->json(['error_info' => 'user not found'], 404);
        }
        return response()->json($user);
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
