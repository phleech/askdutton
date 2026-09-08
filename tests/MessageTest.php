<?php

declare(strict_types=1);

namespace Tests;

use App\MessageService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MessageTest extends TestCase
{
    #[DataProvider('isImageDataProvider')]
    public function test_is_image(string $messageFileContent, $expected): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, "[\"$messageFileContent\"]");
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $messageService = new MessageService($filename);
        $message = $messageService->getMessage(0);

        $this->assertEquals($expected, $message->isImage());
    }

    public static function isImageDataProvider(): array
    {
        return [
            'valid image message' => ['https://www.askdutton.co.uk/profile.png', true],
            'non url message' => ['test', false],
            'url message but non image' => ['https://www.askdutton.co.uk', false],
        ];
    }
}
