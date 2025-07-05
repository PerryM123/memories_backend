<?php
// TODO: If there is a laravel error, instead of just exploding, return 'server error' is ideal??????

namespace App\Http\Controllers;

use App\Domain\ReceiptInfo\Services\ReceiptInfoService;
use App\Exceptions\S3UploadException;
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
        try {
            $validator = Validator::make($request->query(), [
                'page' => 'sometimes|integer|min:1|max:9999'
            ]);
            if ($validator->fails()) {
                Log::error("validation error", ['receiptInfo validation error: ' => $validator->errors()]);
                return response()->json([
                    'error_info' => "validation error"
                ], 400);
            }
            $page = $request->query('page', 1);
            $receiptInfo = $this->ReceiptInfoService->getPaginatedReceipts($page);
            Log::info("index", ['receiptInfo response' => $receiptInfo]);
            return response()->json($receiptInfo);
        } catch (\Exception $e) {
            Log::error('Unexpected error in index for receipt pagination', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error_message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeReceiptInfo(Request $request)
    {
        try{
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
                Log::error("validation error", ['receiptInfo validation error: ' => $validator->errors()]);
                return response()->json([
                    'error_info' => $validator->errors()
                ], 400);
            }
            $validatedData = $validator->validated();
            $title = $validatedData['title'];
            $userWhoPaid = $validatedData['user_who_paid'];
            $receiptInfo = $this->ReceiptInfoService->storeNewReceipt(
                $title, 
                $userWhoPaid, 
                $validatedData['total_amount'],
                $validatedData['person_1_amount'],
                $validatedData['person_2_amount'],
                $validatedData['bought_items'],
                $validatedData['total_amount'],
                $request->file('image')
            );
            Log::info("storeReceiptInfo", ['receiptInfo response' => $receiptInfo]);
            return response()->json($receiptInfo, 201);
        } catch (S3UploadException $e) {
            Log::error('S3UploadException in storeReceiptInfo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file_name' => $e->getUploadFileName()
            ]);
            return response()->json([
                'error_message' => $e->getErrorMessage(),
                'file_name' => $e->getUploadFileName()
            ], 401);
        } catch (\Exception $e) {
            Log::error('Unexpected error in storeReceiptInfo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error_message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    /**
     * Sends an image to OpenAI API to analyze and return the receipt info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function analyzeReceiptImage(Request $request)
    {
        // TODO: Is there a way to not have to always try catch everything? Is there a more DRY way to do this?
        try{
            $validator = Validator::make($request->all(), [
                'image' => 'required|file|image|max:5120', // max 5MB
            ]);
            if ($validator->fails()) {
                Log::error("validation error", ['receiptInfo validation error: ' => $validator->errors()]);
                return response()->json(['error_info' => 'validation error'], 400);
            }
            $receiptInfo = $this->ReceiptInfoService->getInfoFromReceiptImage($request->file('image'));
            // TODO: Make it so that we can pass the $receiptInfo as is instead of with a message
            Log::info("analyzeReceiptImage", ['receiptInfo response' => $receiptInfo]);
            return response()->json([
                'message' => 'Receipt Info Analyzed Successfully',
                'receipt_info' => $receiptInfo
            ], 200);
        } catch (\Exception $e) {
            Log::error('Unexpected error in storeReceiptInfo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error_message' => 'An unexpected error occurred'
            ], 500);
        }
    }

    /**
     * Retrieve detailed information about a specific receipt by its ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getReceiptDetails(string $receipt_id)
    {
        try{
            throw new \Exception('what the hell');
            $validator = Validator::make(['receipt_id' => $receipt_id], [
                'receipt_id' => 'required|integer|min:1'
            ]);
            if ($validator->fails()) {
                Log::error("validation error", ['receiptInfo validation error: ' => $validator->errors()]);
                return response()->json(['error_info' => 'validation error'], 400);
            }
            $validatedData = $validator->validated();
            $receiptInfo = $this->ReceiptInfoService->getReceiptById($validatedData['receipt_id']);
            if (!$receiptInfo) {
                Log::info("getReceiptDetails", ['error_message' => 'receipt ID "' . $receipt_id . '" does not exist']);
                return response()->json([
                    'error_message' => 'receipt ID "' . $receipt_id . '" does not exist'
                ], 404);
            }
            Log::info("getReceiptDetails", ['receiptInfo response' => $receiptInfo]);
            return response()->json(
                $receiptInfo
            , 200);
        } catch (\Exception $e) {
            Log::error('Unexpected error in storeReceiptInfo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'error_message' => 'An unexpected error occurred'
            ], 500);
        }
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
