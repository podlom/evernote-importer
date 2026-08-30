<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Note;

interface NoteExporterInterface
{
    public function exportNote(
        Note $note,
        string $destination
    ): string;
}
