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
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $receiptInfo = $this->ReceiptInfoService->getPaginatedReceipts($page);
        return response()->json($receiptInfo);
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
            'person_1_amount' => 'required|integer|min:1',
            'person_2_amount' => 'required|integer|min:1',
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
            $validatedData['person_1_amount'], 
            $validatedData['person_2_amount'], 
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
