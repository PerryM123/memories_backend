<?php

namespace App\Exceptions;

use Exception;

/**
 * When the S3 Upload fails because of authentication, keys, etc
 */
class S3UploadException extends Exception
{
    private $uploadFileName;
    private $errorMessage;

    /**
     * @param string $uploadFileName
     * @param string $errorMessage
     */
    public function __construct(string $errorMessage, string $uploadFileName)
    {
        $this->errorMessage = $errorMessage;
        $this->uploadFileName = $uploadFileName;
        parent::__construct($errorMessage);
    }
    
    public function getUploadFileName(): string
    {
        return $this->uploadFileName;
    }
    
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
