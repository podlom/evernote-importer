<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Tests\Exporter;

use PHPUnit\Framework\TestCase;
use Podlom\EvernoteImporter\Exporter\ExportContext;

final class ExportContextTest extends TestCase
{
    public function test_creates_export_context(): void
    {
        $context = new ExportContext(
            '/tmp/export'
        );

        self::assertSame(
            '/tmp/export',
            $context->destination
        );
    }
}
