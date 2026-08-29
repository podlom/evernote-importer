<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\Resource;
use Podlom\EvernoteImporter\Exporter\ResourceFilenameGenerator;

final class ResourceFilenameGeneratorTest extends TestCase
{
    public function test_uses_original_filename(): void
    {
        $resource = new Resource(
            mimeType: 'image/jpeg',
            filename: 'photo.jpg'
        );

        $generator = new ResourceFilenameGenerator();

        self::assertSame(
            'photo.jpg',
            $generator->generate($resource)
        );
    }

    public function test_generates_jpeg_filename(): void
    {
        $resource = new Resource(
            mimeType: 'image/jpeg'
        );

        $generator = new ResourceFilenameGenerator();

        self::assertSame(
            'resource.jpg',
            $generator->generate($resource)
        );
    }

    public function test_generates_png_filename(): void
    {
        $resource = new Resource(
            mimeType: 'image/png'
        );

        $generator = new ResourceFilenameGenerator();

        self::assertSame(
            'resource.png',
            $generator->generate($resource)
        );
    }

    public function test_generates_binary_filename_for_unknown_type(): void
    {
        $resource = new Resource(
            mimeType: 'application/octet-stream'
        );

        $generator = new ResourceFilenameGenerator();

        self::assertSame(
            'resource.bin',
            $generator->generate($resource)
        );
    }

    public function test_sanitizes_original_filename(): void
    {
        $resource = new Resource(
            mimeType: 'image/jpeg',
            filename: 'my/photo:test.jpg'
        );

        $generator = new ResourceFilenameGenerator();

        self::assertSame(
            'my-photo-test.jpg',
            $generator->generate($resource)
        );
    }
}
