<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\EnexImporter;
use Podlom\EvernoteImporter\Exporter\ExportContext;
use Podlom\EvernoteImporter\Exporter\ExportPipeline;

final class FullExportPipelineTest extends TestCase
{
    private string $destination;

    public function test_exports_real_evernote_backup(): void
    {
        $importer = new EnexImporter();

        $document = $importer->import(
            __DIR__.'/../Fixtures/evernote-real-export.enex'
        );

        $this->destination = sys_get_temp_dir()
            .'/full-export-test-'.uniqid();

        $pipeline = new ExportPipeline();

        $result = $pipeline->export(
            $document,
            new ExportContext(
                destination: $this->destination
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
            $this->destination.'/notes/Simple Markdown Test.md'
        );

        self::assertFileExists(
            $this->destination.'/notes/Image Test.md'
        );
    }

    protected function tearDown(): void
    {
        if (isset($this->destination) && is_dir($this->destination)) {
            $this->removeDirectory($this->destination);
        }
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
}
