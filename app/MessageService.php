<?php

declare(strict_types=1);

namespace App;

use Exception;

class MessageService
{
    private array $messages = [];

    public function __construct(
        string $jsonFileLocation
    ) {

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
        $message = $this->messages[array_rand($this->messages)];
        if (str_ends_with($message, '.gif')) {
            $message = "<img src='$message' />";
        }

        return $message;
    }
}
