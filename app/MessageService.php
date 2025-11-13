<?php

declare(strict_types=1);

namespace App;

use Exception;
use finfo;

class MessageService
{
    private array $messages = [];

    private $finfo;

    public function __construct(
        string $jsonFileLocation
    ) {
        $this->finfo = new finfo(FILEINFO_MIME);

        if (! file_exists($jsonFileLocation)) {
            throw new Exception('Messages file does not exist');
        }

        $fileContents = file_get_contents($jsonFileLocation);

        if (empty($fileContents)) {
            throw new Exception('Messages file is empty');
        }

        $messages = json_decode($fileContents);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Messages file is not valid JSON');
        }

        $this->messages = $messages;
    }

    public function getMessage(): string
    {
        return $this->messages[array_rand($this->messages)];
    }

    public function isImage(string $message): bool
    {
        if (filter_var($message, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $mimeType = $this->finfo->buffer(file_get_contents($message));

        return str_starts_with($mimeType, 'image');
    }
}
