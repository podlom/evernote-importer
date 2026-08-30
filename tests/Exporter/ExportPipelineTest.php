<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\Exporter\ExportContext;
use Podlom\EvernoteImporter\Exporter\ExportPipeline;
use Podlom\EvernoteImporter\EnexImporter;
use Podlom\EvernoteImporter\Exporter\ExporterInterface;

final class ExportPipelineTest extends TestCase
{
    public function test_exports_document_pipeline(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/evernote-real-export.enex'
        );

        $destination = sys_get_temp_dir()
            .'/export-pipeline-test-'.uniqid();

        $pipeline = new ExportPipeline();

        $result = $pipeline->export(
            $document,
            new ExportContext($destination)
        );

        self::assertSame(
            3,
            $result->notesExported
        );

        self::assertSame(
            3,
            $result->resourcesExported
        );

        self::assertFileExists(
            $destination.'/notes/Simple Markdown Test.md'
        );

        self::assertFileExists(
            $destination.'/notes/Image Test.md'
        );
    }

    public function test_pipeline_is_document_exporter(): void
    {
        $pipeline = new ExportPipeline();

        self::assertInstanceOf(
            ExporterInterface::class,
            $pipeline
        );
    }
}
