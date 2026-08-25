<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\EnexImporter;

final class RealEvernoteExportTest extends TestCase
{
    public function test_imports_real_evernote_export(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/evernote-real-export.enex'
        );

        self::assertGreaterThan(
            0,
            $document->count()
        );
    }

    public function test_real_export_contains_expected_metadata(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/evernote-real-export.enex'
        );

        self::assertCount(
            3,
            $document->notes
        );

        self::assertSame(
            'Simple Markdown Test',
            $document->notes[0]->title
        );

        self::assertContains(
            'simple',
            $document->notes[0]->tags
        );

        self::assertSame(
            'Image Test',
            $document->notes[1]->title
        );

        self::assertCount(
            3,
            $document->notes[1]->resources
        );
    }
}
