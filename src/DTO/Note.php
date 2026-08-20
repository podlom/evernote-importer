<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\DTO;

use DateTimeImmutable;

final readonly class Note
{
    /**
     * @param string[] $tags
     * @param Resource[] $resources
     */
    public function __construct(
        public string $title,
        public string $content,
        public array $tags = [],
        public array $resources = [],
        public ?string $author = null,
        public ?DateTimeImmutable $createdAt = null,
        public ?DateTimeImmutable $updatedAt = null,
    ) {}
}
