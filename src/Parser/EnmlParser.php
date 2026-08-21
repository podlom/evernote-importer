<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\Exception\InvalidEnexFileException;

final class EnmlParser
{
    public function parse(string $content): string
    {
        $content = trim($content);

        if ($content === '') {
            return '';
        }

        return $this->removeXmlDeclaration(
            $content
        );
    }

    private function removeXmlDeclaration(string $content): string
    {
        return preg_replace(
            '/^<\?xml.*?\?>/s',
            '',
            $content
        ) ?? $content;
    }
}
