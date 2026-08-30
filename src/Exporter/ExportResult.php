<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

final readonly class ExportResult
{
    public function __construct(
        public int $notesExported,
        public int $resourcesExported,
    ) {
    }
}
