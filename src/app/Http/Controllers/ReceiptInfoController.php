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

        // TODO: Change add this into service. Example: $ReceiptInfoService->storeNewReceipt();
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
        // TODO: This $receipt_info is dummy data. Open AI API will be set here
        $receipt_info = [
            "items" => [
                [ "name" => "ハーゲンミニCロウチャクリキーウカ", "price_total" => 218 ],
                [ "name" => "オリジナルスフラッドオレンジ", "price_total" => 204 ],
                [ "name" => "オカメ スコイサットS-903", "price_total" => 264 ],
                [ "name" => "アタックウオシEXヘヤカカ850g", "price_total" => 308 ],
                [ "name" => "コウサンウオトンジヤ玉150×3", "price_total" => 78 ],
                [ "name" => "セブンスターリサンゴールド", "price_total" => 499 ],
                [ "name" => "ワイドハイターEXパワー820ml", "price_total" => 328 ],
                [ "name" => "サラヤ テイユコット100ムコち56", "price_total" => 280 ],
                [ "name" => "バナナ", "price_total" => 256 ],
                [ "name" => "ハウスバイング35g", "price_total" => 100 ],
                [ "name" => "トマト コツコ", "price_total" => 398 ],
                [ "name" => "タンノンビオカセイタクブドウ", "price_total" => 326 ],
                [ "name" => "タンノンビオ シチリアレモン 4コ", "price_total" => 163 ],
                [ "name" => "コイワイヨーグルトホンボウ400g", "price_total" => 199 ],
                [ "name" => "ミヤマ イチオシムキチ 200g", "price_total" => 153 ],
                [ "name" => "コウサンウオカトリムネニク", "price_total" => 596 ],
            ],
            "receipt_total" => 4626
        ];

        return response()->json([
            'message' => 'Image uploaded successfully',
            'path' => $path,
            'url' => Storage::disk('s3')->url($path),
            'receipt_info' => $receipt_info
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
