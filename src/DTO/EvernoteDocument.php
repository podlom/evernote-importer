<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\DTO;

final readonly class EvernoteDocument
{
    /**
     * @param Note[] $notes
     */
    public function __construct(
        public array $notes = [],
    ) {
    }

    public function count(): int
    {
        return count($this->notes);
    }
}
