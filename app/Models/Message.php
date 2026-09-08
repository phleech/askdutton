<?php

declare(strict_types=1);

namespace App\Models;

use finfo;

class Message
{
    private $finfo;

    public function __construct(
        public readonly int $index,
        public readonly string $body
    ) {
        $this->finfo = new finfo(FILEINFO_MIME);
    }

    public function isImage(): bool
    {
        if (filter_var($this->body, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $mimeType = $this->finfo->buffer(file_get_contents($this->body));

        return str_starts_with($mimeType, 'image');
    }
}
