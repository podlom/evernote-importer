<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\EnexImporter;
use Podlom\EvernoteImporter\Exporter\ExportContext;
use Podlom\EvernoteImporter\Exporter\ExportPipeline;

final class FullExportPipelineTest extends TestCase
{
    public function test_exports_real_evernote_backup(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/evernote-real-export.enex'
        );

        $destination = sys_get_temp_dir()
            .'/full-export-test-'.uniqid();

        $pipeline = new ExportPipeline();

        $result = $pipeline->export(
            $document,
            new ExportContext(
                destination: $destination
            )
        );

        self::assertSame(
            3,
            $result->notesExported
        );

        self::assertGreaterThan(
            0,
            $result->resourcesExported
        );

        self::assertFileExists(
            $destination.'/notes/Simple Markdown Test.md'
        );

        self::assertFileExists(
            $destination.'/notes/Image Test.md'
        );
    }
}
