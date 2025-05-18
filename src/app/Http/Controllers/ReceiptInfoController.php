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
        
        // Decode bought_items JSON string from the frontend
        $requestData = $request->all();
        if (isset($requestData['bought_items']) && is_string($requestData['bought_items'])) {
            $requestData['bought_items'] = json_decode($requestData['bought_items'], true);
        }
        
        $validator = Validator::make($requestData, [
            'image' => 'required|file|image|max:5120', // max 5MB
            'title' => 'required|string|max:255',
            'user_who_paid' => 'required|string|max:255',
            'person_1_amount' => 'required|integer|min:1',
            'person_2_amount' => 'required|integer|min:1',
            'bought_items' => 'required|array',
            'bought_items.*.name' => 'required|string|max:255',
            'bought_items.*.price_total' => 'required|integer|min:1',
            // TODO: Need to add validation that states who_paid cannot be an empty string... 
            'bought_items.*.who_paid' => 'nullable|string|max:255',
            'total_amount' => 'required|integer|min:1',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error_info' => $validator->errors()
            ], 400);
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
            $validatedData['bought_items'], 
            $validatedData['total_amount'], 
            $request->file('image')
        );
        return response()->json([
            'message' => 'Receipt Info Saved Successfully',
        ], 201);
    }

    /**
     * TODO: comment必須
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function analyzeReceiptImage(Request $request)
    {
        Log::info('storeReceiptInfo function');
        $validator = Validator::make($request->all(), [
            'image' => 'required|file|image|max:5120', // max 5MB
        ]);
        if ($validator->fails()) {
            return response()->json(['error_info' => 'validation error'], 400);
        }
        Log::info('storeReceiptInfo check validator: ', [ 'validator' => $validator]);
        $receiptInfo = $this->ReceiptInfoService->analyzeReceiptImage($request->file('image'));
        return response()->json([
            'message' => 'Receipt Info Analyzed Successfully',
            'receipt_info' => $receiptInfo
        ], 200);
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
