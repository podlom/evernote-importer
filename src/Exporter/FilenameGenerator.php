<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Exporter;

final class FilenameGenerator
{
    public function generate(
        string $title
    ): string {
        $filename = trim($title);

        if ($filename === '') {
            return 'untitled.md';
        }

        $filename = preg_replace(
            '/[<>:"\/\\\\|?*\x00-\x1F]/',
            '-',
            $filename
        );

        $filename = preg_replace(
            '/\s+/',
            ' ',
            $filename
        );

        $filename = trim(
            $filename,
            " .-"
        );

        return $filename.'.md';
    }
}
