<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\DTO\Note;
use Podlom\EvernoteImporter\Exporter\MarkdownExporter;
use Podlom\EvernoteImporter\EnexImporter;

final class MarkdownExporterTest extends TestCase
{
    public function test_exports_note_as_markdown_file(): void
    {
        $document = new EvernoteDocument(
            notes: [
                new Note(
                    title: 'My Laravel Note',
                    content: 'Laravel dependency injection example.',
                    tags: [
                        'Laravel',
                        'PHP',
                    ],
                ),
            ],
        );

        $destination = sys_get_temp_dir()
            .'/evernote-export-test';

        if (is_dir($destination)) {
            $this->removeDirectory($destination);
        }

        $exporter = new MarkdownExporter();

        $exporter->export(
            $document,
            $destination
        );

        $file = $destination.'/notes/My Laravel Note.md';

        self::assertFileExists($file);

        self::assertStringContainsString(
            'Laravel dependency injection example.',
            file_get_contents($file)
        );

        self::assertStringContainsString(
            'tags:',
            file_get_contents($file)
        );
    }

    private function removeDirectory(string $directory): void
    {
        foreach (glob($directory.'/*') ?: [] as $file) {
            is_dir($file)
                ? $this->removeDirectory($file)
                : unlink($file);
        }

        rmdir($directory);
    }

    public function test_exports_embedded_image_reference(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/note-with-image.enex'
        );

        $destination = sys_get_temp_dir()
            .'/markdown-image-export-test';

        $exporter = new MarkdownExporter();

        $exporter->export(
            $document,
            $destination
        );

        $markdown = file_get_contents(
            $destination.'/notes/note-with-image.md'
        );

        self::assertStringContainsString(
            '![image](../resources/',
            $markdown
        );
    }

    public function test_exports_notebook_metadata(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/note-with-notebook.enex'
        );

        $destination = sys_get_temp_dir()
            .'/markdown-notebook-export-test';

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

        $markdown = file_get_contents(
            $files[0]
        );

        self::assertNotFalse(
            $markdown
        );

        self::assertStringContainsString(
            'notebook: "Laravel Course"',
            $markdown
        );
    }
}
