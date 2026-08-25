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
}
