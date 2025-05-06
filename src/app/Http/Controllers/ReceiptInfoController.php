<?php

namespace App\Http\Controllers;

use App\Domain\ReceiptInfo\Services\ReceiptInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReceiptInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReceiptInfoService $ReceiptInfoService)
    {

        Log::info('[LOG] ReceiptInfoController', ['ReceiptInfoService' => $ReceiptInfoService]);
        /**
         * Idea:
         * 1. Only get the items in counts of 10 (page 2 = 11 - 20, page 3 = 21 - 30)
         */
        $receiptInfo = $ReceiptInfoService->getAllReceipts();
        Log::info('[LOG] ReceiptInfoController', ['receiptInfo' => $receiptInfo]);
        return response()->json('hello');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReceiptInfo(Request $request)
    {
        $request->validate([
            'image' => 'required|file|image|max:5120', // max 5MB
        ]);

        $file = $request->file('image');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        Log::info('[LOG] ReceiptInfoController: before');
        $path = Storage::disk('s3')->putFileAs('uploads/images', $file, $filename);
        Log::info('[LOG] ReceiptInfoController: after');
        Log::info('[LOG] ReceiptInfoController: storeReceiptInfo: ', [
            'request' => $request,
            'file' => $file,
            'filename' => $filename,
            'path' => $path,
        ]);
        //
        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => Storage::disk('s3')->url($path),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
