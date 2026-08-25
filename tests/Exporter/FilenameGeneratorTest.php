<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\EnexImporter;
use Podlom\EvernoteImporter\Exporter\FilenameGenerator;
use Podlom\EvernoteImporter\Exporter\MarkdownExporter;

final class FilenameGeneratorTest extends TestCase
{
    public function test_generates_filename_from_title(): void
    {
        $generator = new FilenameGenerator();

        self::assertSame(
            'Laravel Course.md',
            $generator->generate(
                'Laravel Course'
            )
        );
    }

    public function test_removes_invalid_filesystem_characters(): void
    {
        $generator = new FilenameGenerator();

        self::assertSame(
            'API Design- Version 2-Final.md',
            $generator->generate(
                'API Design: Version 2/Final'
            )
        );
    }

    public function test_generates_untitled_filename(): void
    {
        $generator = new FilenameGenerator();

        self::assertSame(
            'untitled.md',
            $generator->generate('')
        );
    }

    public function test_exports_safe_filename(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/note-with-special-title.enex'
        );

        $destination = sys_get_temp_dir()
            .'/markdown-safe-filename-test-'.uniqid();

        $exporter = new MarkdownExporter();

        $exporter->export(
            $document,
            $destination
        );

        $files = glob(
            $destination.'/notes/*.md'
        );

        self::assertCount(
            1,
            $files
        );

        self::assertStringEndsWith(
            'API Design- Version 2-Final.md',
            $files[0]
        );
    }
}
