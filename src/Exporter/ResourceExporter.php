<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

use Podlom\EvernoteImporter\DTO\Resource;
use RuntimeException;

final class ResourceExporter
{
    public function __construct(
        private readonly ResourceFilenameGenerator $filenameGenerator = new ResourceFilenameGenerator(),
    ) {
    }

    public function export(
        Resource $resource,
        string $destination
    ): string {
        if (!is_dir($destination)) {
            mkdir(
                $destination,
                0777,
                true
            );
        }

        $filename = $this->filenameGenerator->generate(
            $resource
        );

        $path = $destination.'/'.$filename;

        $data = base64_decode(
            $resource->data ?? '',
            true
        );

        if ($data === false) {
            throw new RuntimeException(
                'Invalid resource data'
            );
        }

        file_put_contents(
            $path,
            $data
        );

        return $path;
    }
}
