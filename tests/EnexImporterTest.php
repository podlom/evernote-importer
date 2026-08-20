<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\EnexImporter;

final class EnexImporterTest extends TestCase
{
    public function test_imports_laravel_note(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
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
}
