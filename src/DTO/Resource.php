<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\DTO;

final readonly class Resource
{
    public function __construct(
        public string $mimeType,
        public ?string $hash = null,
        public ?string $filename = null,
        public ?string $data = null,
        public ?int $width = null,
        public ?int $height = null,
    ) {
    }

    public function size(): int
    {
        if ($this->data === null) {
            return 0;
        }

        $decoded = base64_decode(
            $this->data,
            true
        );

        return $decoded === false
            ? 0
            : strlen($decoded);
    }
}
