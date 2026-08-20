<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use DateTimeImmutable;

final class EvernoteDateParser
{
    public function parse(?string $value): ?DateTimeImmutable
    {
        if ($value === null || $value === '') {
            return null;
        }

        return DateTimeImmutable::createFromFormat(
            'Ymd\THis\Z',
            $value
        ) ?: null;
    }
}
