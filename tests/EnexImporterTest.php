<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\EnexImporter;

final class EnexImporterTest extends TestCase
{
    private function importer(): EnexImporter
    {
        return new EnexImporter();
    }

    public function test_imports_laravel_note(): void
    {
        $document = $this->importer()->import(
            __DIR__.'/Fixtures/laravel-lesson.enex'
        );

        self::assertCount(
            1,
            $document->notes
        );

        $note = $document->notes[0];

        self::assertSame(
            '2025-06-16 Урок 1 - Вступ до Laravel',
            $note->title
        );

        self::assertContains(
            'Laravel',
            $note->tags
        );

        self::assertSame(
            'Taras Shkodenko',
            $note->author
        );
    }


    public function test_imports_multiple_notes(): void
    {
        $document = $this->importer()->import(
            __DIR__.'/Fixtures/multiple-notes-5.enex'
        );

        self::assertCount(
            5,
            $document->notes
        );

        self::assertNotEmpty(
            $document->notes[0]->title
        );
    }


    public function test_imports_laravel_note_content(): void
    {
        $document = $this->importer()->import(
            __DIR__.'/Fixtures/laravel-lesson.enex'
        );

        $note = $document->notes[0];

        self::assertNotEmpty(
            $note->content
        );

        self::assertStringContainsString(
            'Урок 1',
            $note->content
        );

        self::assertStringNotContainsString(
            '<?xml',
            $note->content
        );
    }
}
