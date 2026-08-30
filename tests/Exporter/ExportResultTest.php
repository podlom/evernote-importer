<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\Exporter\ExportResult;

final class ExportResultTest extends TestCase
{
    public function test_creates_export_result(): void
    {
        $result = new ExportResult(
            notesExported: 10,
            resourcesExported: 25,
        );

        self::assertSame(
            10,
            $result->notesExported
        );

        self::assertSame(
            25,
            $result->resourcesExported
        );
    }
}
