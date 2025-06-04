<?php

namespace App\Infrastructure\OpenAi\Contracts;

use App\Domain\ReceiptInfo\DTOs\AnalyzedReceiptDTO;
use Illuminate\Http\UploadedFile;

interface ReceiptAnalysisServiceInterface
{
    public function getInfoFromReceiptImage(UploadedFile $imageFile): ?AnalyzedReceiptDTO;
}
