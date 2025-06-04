<?php

namespace App\Infrastructure\OpenAi\Services;

use App\Domain\ReceiptInfo\DTOs\AnalyzedReceiptDTO;
use App\Infrastructure\OpenAi\Contracts\ReceiptAnalysisServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReceiptAnalysisService implements ReceiptAnalysisServiceInterface
{
    public function getInfoFromReceiptImage(UploadedFile $imageFile): ?AnalyzedReceiptDTO
    {
        $apiKey = config('services.openai.apiKey');
        $apiEndpoint = config('services.openai.apiEndpoint');
        if (!$apiKey || !$apiEndpoint) {
            throw new \Exception('OpenAI API configuration is missing');
        }
        $base64Image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($imageFile));
        try {
            $response = Http::withToken($apiKey, 'Bearer')
                ->post($apiEndpoint . '/v1/chat/completions', [
                    'model' => 'gpt-4.1-mini',
                    'messages' => [
                        [
                            'role' => 'user', 
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => "I have a receipt image attached. The left side is the item. The right side is the price. Please ignore phrases like '２コX単', 'スキャンレシ', and ignore discounts on the right side. Please do not add ```json to the final response. Please return the final response in plain text. Can you give receipt information in JSON format based on the typescript interfaces below? ```interface Receipt {  items: Item[]  // 合計  receipt_total: number}interface Item {  name: string  price_total: number}```"
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => $base64Image
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
            $responseData = $response->json();
            if (isset($responseData['error']) && $responseData['error']) {
                Log::error(['error message: ' => $responseData['error']['message']]);
                throw new \Exception($responseData['error']['message']);
            }
            Validator::make($responseData, [
                'choices' => 'required|array',
                'choices.0.message.content' => 'required|string',
            ])->validate();
            $openAiContentJson = json_decode($responseData['choices'][0]['message']['content']);
            return new AnalyzedReceiptDTO(
                items: $openAiContentJson->items,
                receipt_total: $openAiContentJson->receipt_total
            );
        }
        catch (\Exception $e) {
            Log::error('API Request Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
