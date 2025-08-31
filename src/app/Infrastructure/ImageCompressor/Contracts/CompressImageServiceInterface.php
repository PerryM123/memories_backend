<?php

namespace App\Infrastructure\ImageCompressor\Contracts;

use Illuminate\Http\UploadedFile;

interface CompressImageServiceInterface
{
    // TODO: Do we need to return a DTO? Isn't returning a UploadedFile enough? Need a return type here at some point...
    public function compressImage(UploadedFile $imageFile);
}
