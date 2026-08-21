<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\EvernoteDocument;

interface ExporterInterface
{
    public function export(
        EvernoteDocument $document,
        string $destination
    ): void;
}
