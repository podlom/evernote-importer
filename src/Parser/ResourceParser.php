<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\DTO\Resource;
use SimpleXMLElement;

final class ResourceParser
{
    public function parse(SimpleXMLElement $xml): Resource
    {
        return new Resource(
            mimeType: (string) $xml->mime,
            filename: $this->extractFilename($xml),
            data: $this->extractData($xml),
        );
    }

    private function extractData(
        SimpleXMLElement $xml
    ): ?string {
        $data = trim((string) $xml->data);

        return $data !== ''
            ? $data
            : null;
    }

    private function extractFilename(
        SimpleXMLElement $xml
    ): ?string {
        return isset($xml->{'resource-attributes'}->{'file-name'})
            ? (string) $xml->{'resource-attributes'}->{'file-name'}
            : null;
    }
}
