<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\Exporter\MarkdownExporter;

final class MarkdownExporterSingleNoteTest extends TestCase
{
    public function test_exports_single_note(): void
    {
        $destination = sys_get_temp_dir()
            .'/markdown-single-note-test-'.uniqid();

        $note = new Note(
            title: 'Single Note Test',
            content: '<div>Hello Markdown</div>',
            tags: [
                'test',
            ],
        );

        $exporter = new MarkdownExporter();

        $path = $exporter->exportNote(
            $note,
            $destination
        );

        self::assertFileExists(
            $path
        );

        self::assertStringEndsWith(
            'Single Note Test.md',
            $path
        );
    }
}
