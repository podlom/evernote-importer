<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\DTO\Note;
use SimpleXMLElement;

final class NoteParser
{
    public function __construct(
        private readonly EvernoteDateParser $dateParser = new EvernoteDateParser(),
    ) {
    }

    public function parse(SimpleXMLElement $xml): Note
    {
        return new Note(
            title: (string) $xml->title,

            content: $this->extractContent($xml),

            tags: $this->extractTags($xml),

            author: $this->extractAuthor($xml),

            createdAt: $this->dateParser->parse(
                (string) $xml->created
            ),

            updatedAt: $this->dateParser->parse(
                (string) $xml->updated
            ),
        );
    }

    private function extractTags(
        SimpleXMLElement $xml
    ): array {
        $tags = [];

        foreach ($xml->tag as $tag) {
            $tags[] = (string) $tag;
        }

        return $tags;
    }

    private function extractContent(
        SimpleXMLElement $xml
    ): string {
        return (string) $xml->content;
    }

    private function extractAuthor(
        SimpleXMLElement $xml
    ): ?string {
        if (!isset($xml->{'note-attributes'}->author)) {
            return null;
        }

        return (string)
        $xml->{'note-attributes'}->author;
    }
}
