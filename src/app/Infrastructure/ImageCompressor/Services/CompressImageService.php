<?php

namespace App\Infrastructure\imageCompressor\Services;

use App\Domain\ReceiptInfo\DTOs\AnalyzedReceiptDTO;
use App\Infrastructure\ImageCompressor\Contracts\CompressImageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CompressImageService implements CompressImageServiceInterface
{
    // TODO: Need a return type...
    public function compressImage(UploadedFile $imageFile)
    {
        Log::info('perry: testmm: compressImage: ', [
            'imageFile' => $imageFile
        ]);
        $bearerToken = config('services.compressor.bearerToken');
        $apiEndpoint = config('services.compressor.apiEndpoint');
        Log::info('perry: compressImage function: ', [
            'config_application' => config('services.application.bearerToken'),
            'bearerToken' => $bearerToken,
            'apiEndpoint' => $apiEndpoint,
            'env_bearer_token' => env('IMAGE_COMPRESSOR_BEARER_TOKEN'),
            'config_bearer_token' => config('services.compressor.bearerToken'),
            'env_api_endpoint' => env('IMAGE_COMPRESSOR_API_ENDPOINT'),
            'config_api_endpoint' => config('services.compressor.apiEndpoint'),    
            'url maybe' => $apiEndpoint . '/v1/compress'
        ]);
        if (!$bearerToken || !$apiEndpoint) {
            throw new \Exception('Image Compressor configuration is missing');
        }
        $base64Image = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($imageFile));
        try {
            $response = Http::withToken($bearerToken, 'Bearer')
                ->post($apiEndpoint . '/v1/compress');
            $responseData = $response->json();
            Log::info('perry: after compress request: ', [
                'responseData' => $responseData
            ]);
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
