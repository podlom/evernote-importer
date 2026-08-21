<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\DTO;

final readonly class Resource
{
    public function __construct(
        public string $mimeType,
        public ?string $filename = null,
        public ?string $data = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $hash = null,
    ) {
    }

    public function size(): int
    {
        if ($this->data === null) {
            return 0;
        }

        return strlen(base64_decode($this->data, true) ?: '');
    }
}
