<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

final class EnmlCleaner
{
    public function clean(string $content): string
    {
        $content = preg_replace(
            '/<!DOCTYPE.*?>/s',
            '',
            $content
        );

        $content = preg_replace(
            '/<\/?en-note>/',
            '',
            $content
        );

        return trim($content);
    }
}
