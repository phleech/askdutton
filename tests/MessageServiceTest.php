<?php

declare(strict_types=1);

namespace Tests;

use App\MessageService;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MessageServiceTest extends TestCase
{
    public function test_exception_is_thrown_if_json_file_is_missing(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Messages file does not exist');

        $messageService = new MessageService('aFileWhichDoesntExist.json');
    }

    public function test_exception_is_thrown_if_json_file_is_empty(): void
    {
        $tempJsonFileHandler = tmpfile();
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Messages file is empty');

        $messageService = new MessageService($filename);
    }

    public function test_exception_is_thrown_if_json_file_is_does_not_contain_valid_json(): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, 'invalid');
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Messages file is not valid JSON');

        $messageService = new MessageService($filename);
    }

    public function test_get_message_returns_a_message(): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, '["example message"]');
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $messageService = new MessageService($filename);

        $this->assertEquals('example message', $messageService->getMessage());
    }

    #[DataProvider('isImageDataProvider')]
    public function test_is_image(string $messageFileContent, $expected): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, "[\"$messageFileContent\"]");
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $messageService = new MessageService($filename);
        $message = $messageService->getMessage();

        $this->assertEquals($expected, $messageService->isImage($message));
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
