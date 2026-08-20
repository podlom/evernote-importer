<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\Exception\InvalidEnexFileException;
use SimpleXMLElement;

final class EnexReader
{
    public function read(string $filename): SimpleXMLElement
    {
        if (! file_exists($filename)) {
            throw new InvalidEnexFileException(
                "ENEX file not found: {$filename}"
            );
        }

        $content = file_get_contents($filename);

        if ($content === false) {
            throw new InvalidEnexFileException(
                "Unable to read ENEX file: {$filename}"
            );
        }

        libxml_use_internal_errors(true);

        $xml = simplexml_load_string(
            $content,
            SimpleXMLElement::class,
            LIBXML_NONET
        );

        if ($xml === false) {
            throw new InvalidEnexFileException(
                "Invalid ENEX XML: {$filename}"
            );
        }

        return $xml;
    }
}
