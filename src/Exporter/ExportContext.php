<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

final readonly class ExportContext
{
    public function __construct(
        public string $destination,
    ) {
    }
}
