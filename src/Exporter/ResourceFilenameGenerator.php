<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Resource;

final class ResourceFilenameGenerator
{
    public function generate(
        Resource $resource
    ): string {
        if ($resource->filename !== null) {
            return $this->sanitize(
                $resource->filename
            );
        }

        return match ($resource->mimeType) {
            'image/jpeg' => 'resource.jpg',
            'image/png' => 'resource.png',
            'image/gif' => 'resource.gif',
            'application/pdf' => 'resource.pdf',
            default => 'resource.bin',
        };
    }

    private function sanitize(
        string $filename
    ): string {
        $filename = preg_replace(
            '/[<>:"\/\\\\|?*\x00-\x1F]/',
            '-',
            $filename
        );

        return trim(
            $filename,
            " .-"
        );
    }
}
