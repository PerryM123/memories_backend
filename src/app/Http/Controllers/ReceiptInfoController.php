<?php

namespace App\Http\Controllers;

use App\Domain\ReceiptInfo\Services\ReceiptInfoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReceiptInfoController extends Controller
{
    private ReceiptInfoService $ReceiptInfoService;

    public function __construct(ReceiptInfoService $ReceiptInfoService) {
        $this->ReceiptInfoService = $ReceiptInfoService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        Log::info('[LOG] ReceiptInfoController', ['ReceiptInfoService' => $this->ReceiptInfoService]);
        /**
         * Idea:
         * 1. Only get the items in counts of 10 (page 2 = 11 - 20, page 3 = 21 - 30)
         */
        $receiptInfo = $this->ReceiptInfoService->getAllReceipts();
        Log::info('[LOG] ReceiptInfoController', ['receiptInfo' => $receiptInfo]);
        return response()->json('hello', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReceiptInfo(Request $request)
    {
        Log::info('storeReceiptInfo function');
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|image|max:5120', // max 5MB
            'title' => 'required|string|max:255',
            'user_who_paid' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['error_info' => 'validation error'], 400);
        }
        Log::info('storeReceiptInfo check validator: ', [ 'validator' => $validator]);
        $receiptInfo = $this->ReceiptInfoService->analyzeReceiptImage($request->file('image'));
        Log::info('storeReceiptInfo after analyzeReceiptImage: ', $receiptInfo);

        $validatedData = $validator->validated();
        $title = $validatedData['title'];
        $userWhoPaid = $validatedData['user_who_paid'];
        $this->ReceiptInfoService->storeNewReceipt(
            $title, 
            $userWhoPaid, 
            // TODO: Why is receipt_total not inferable and has no intellesense?
            $receiptInfo['receipt_total'], 
            $request->file('image')
        );
        return response()->json([
            'message' => 'Receipt Info Saved Successfully',
            'receipt_info' => $receiptInfo
        ], 201);
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
