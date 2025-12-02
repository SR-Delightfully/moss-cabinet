<?php

namespace App\Helpers;

use App\Helpers\Core\Result;
use Psr\Http\Message\UploadedFileInterface;

class FileUploadHelper
{
    /**
     * Uploads a file with validation and returns a result.
     * @param UploadedFileInterface $uploadedFile the uploaded file from the request
     * @param array $config Configuration options:
     * - 'directory' (string): Upload directory path (required)
     * - 'allowedTypes' (array): Array of allowed media types (required)
     * - 'maxSize' (int): Maximum file size in bytes (required)
     * - 'filenamePrefix (string): Prefix for generated filenames (default: 'upload_')
     * @return Result Success with filename, or failure with error message.
     */
    public static function upload(UploadedFileInterface $uploadedFile, array $config): Result {

    }

}
