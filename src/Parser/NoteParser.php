<?php

declare(strict_types=1);

namespace Podlom\EvernoteImporter\Parser;

use Podlom\EvernoteImporter\DTO\Note;
use SimpleXMLElement;

final class NoteParser
{
    public function __construct(
        private readonly EvernoteDateParser $dateParser = new EvernoteDateParser(),
        private readonly EnmlParser $enmlParser = new EnmlParser(),
        private readonly ResourceParser $resourceParser = new ResourceParser(),
        private readonly EnmlMediaResolver $mediaResolver = new EnmlMediaResolver(),
    ) {
    }

    public function parse(SimpleXMLElement $xml): Note
    {
        $resources = $this->extractResources($xml);

        $content = $this->enmlParser->parse(
            $this->extractContent($xml)
        );

        $content = $this->mediaResolver->resolve(
            $content,
            $resources
        );

        return new Note(
            title: (string) $xml->title,

            content: $content,

            tags: $this->extractTags($xml),

            author: $this->extractAuthor($xml),

            createdAt: $this->dateParser->parse(
                (string) $xml->created
            ),

            updatedAt: $this->dateParser->parse(
                (string) $xml->updated
            ),

            resources: $resources,
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

    private function extractResources(
        SimpleXMLElement $xml
    ): array {
        $resources = [];

        foreach ($xml->xpath('./resource') ?: [] as $resource) {
            $resources[] = $this->resourceParser->parse(
                $resource
            );
        }

        return $resources;
    }
}
