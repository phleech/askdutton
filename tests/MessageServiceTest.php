<?php

declare(strict_types=1);

namespace Tests;

use App\MessageService;
use Exception;
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

    public function test_get_message_returns_correct_message_if_the_supplied_index_is_valid(): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, '["example message 1", "example message 2", "example message 3"]');
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $message = (new MessageService($filename))->getMessage(2);

        $this->assertEquals(2, $message->index);
        $this->assertEquals('example message 3', $message->body);
    }

    public function test_get_message_returns_an_empty_message_if_the_supplied_index_is_invalid(): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, '["example message"]');
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $messageService = new MessageService($filename);
        $this->assertEquals('', $messageService->getMessage(2));
    }

    public function test_get_random_message_returns_a_message(): void
    {
        $tempJsonFileHandler = tmpfile();
        fwrite($tempJsonFileHandler, '["example message"]');
        $filename = stream_get_meta_data($tempJsonFileHandler)['uri'];

        $messageService = new MessageService($filename);

        $this->assertEquals('example message', $messageService->getRandomMessage()->body);
    }
}
