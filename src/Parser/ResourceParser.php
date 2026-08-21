<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\DTO\Resource;
use SimpleXMLElement;

final class ResourceParser
{
    public function parse(
        SimpleXMLElement $xml
    ): Resource {
        $data = $this->extractData($xml);

        return new Resource(
            hash: $this->calculateHash($data),
            mimeType: (string) $xml->mime,
            filename: $this->extractFilename($xml),
            data: $data,
            width: $this->extractInteger($xml->width),
            height: $this->extractInteger($xml->height),
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

    private function calculateHash(
        ?string $data
    ): string {
        if ($data === null) {
            return '';
        }

        $decoded = base64_decode(
            $data,
            true
        );

        return $decoded === false
            ? ''
            : md5($decoded);
    }

    private function extractFilename(
        SimpleXMLElement $xml
    ): ?string {
        if (!isset(
            $xml->{'resource-attributes'}->{'file-name'}
        )) {
            return null;
        }

        return (string)
        $xml->{'resource-attributes'}->{'file-name'};
    }

    private function extractInteger(
        SimpleXMLElement $value
    ): ?int {
        return $value != ''
            ? (int) $value
            : null;
    }
}
