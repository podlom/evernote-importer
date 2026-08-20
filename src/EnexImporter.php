<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter;

use Podlom\EvernoteImporter\DTO\EvernoteDocument;
use Podlom\EvernoteImporter\Exception\InvalidEnexFileException;
use Podlom\EvernoteImporter\Parser\EnexReader;
use Podlom\EvernoteImporter\Parser\NoteParser;

final class EnexImporter
{
    public function import(string $filename): EvernoteDocument
    {
        $this->validateFile($filename);

        $reader = new EnexReader();

        $xml = $reader->read($filename);

        $noteParser = new NoteParser();

        $notes = [];

        foreach ($xml->note as $noteXml) {
            $notes[] = $noteParser->parse($noteXml);
        }

        return new EvernoteDocument(
            notes: $notes
        );
    }

    private function validateFile(string $filename): void
    {
        if (! file_exists($filename)) {
            throw new InvalidEnexFileException(
                "ENEX file not found: {$filename}"
            );
        }

        if (! is_readable($filename)) {
            throw new InvalidEnexFileException(
                "ENEX file is not readable: {$filename}"
            );
        }

        $extension = strtolower(
            pathinfo($filename, PATHINFO_EXTENSION)
        );

        if ($extension !== 'enex') {
            throw new InvalidEnexFileException(
                "Expected ENEX file, received: {$extension}"
            );
        }
    }
}
